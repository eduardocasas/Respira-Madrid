<?php

namespace AppBundle\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    private $stationCollection;
    private $itemCollection;

    public function getFileAction($fileName)
    {
        $filepath = $this->getFolderPath().$fileName.'.pdf';
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filepath));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($filepath).'";');
        $response->headers->set('Content-length', filesize($filepath));
        $response->sendHeaders();
        $fileContent = readfile($filepath);
        unlink($filepath);

        return $response->setContent($fileContent);
    }

    public function printAction(Request $request)
    {
        $content = $this->renderView('home/index.html.twig', ['printFile' => true] + (($request->get('_route') == 'home_print')
            ? $this->getViewVars($request, $this->getDefaultRecords()) + $this->getDefaultViewVars()
            : $this->getViewVars($request, $this->getFilteredRecords($request)) + $this->getFilteredViewVars($request)
        ));
        $fileName = $this->getUnrepeatedRandomFileName();
        $this->createHtmlFile($fileName, $content);
        shell_exec('cd '.$this->getFolderPath().' && xvfb-run --auto-servernum --server-num=1 -a wkhtmltopdf '.$fileName.'.html '.$fileName.'.pdf');
        unlink($this->getFolderPath().$fileName.'.html');

        return new JsonResponse(
            ['url' => $this->generateUrl('home_print_get_file', ['fileName' => $fileName])]
        );
    }

    public function filterAction(Request $request)
    {
        $records = $this->getFilteredRecords($request);

        return ($request->isXmlHttpRequest())
            ? $this->render('home/records.html.twig', $this->getDateVars($request) + [
                'records' => $records,
                'recordsForTable' => $this->getRecordsForTable($records),
                'selectedStation' => $request->query->get('station'),
                'stationCollection' => $this->getStationCollection(),
                'itemCollection' => $this->getDoctrine()->getRepository('AppBundle:Item')->getCollectionById(),
                'selectedlast24Hours' => $request->query->has('last_24_hours'),
                'siteTitle' => $this->getTitle($request),
            ])
            : $this->render('home/index.html.twig', $this->getViewVars($request, $records) + $this->getFilteredViewVars($request) + [
                'section' => 'home',
            ]);
    }

    public function indexAction(Request $request)
    {
        return $this->render('home/index.html.twig', $this->getViewVars($request, $this->getDefaultRecords()) + $this->getDefaultViewVars() + [
            'section' => 'home',
        ]);
    }

    private function getFilteredRecords($request)
    {
        return $this->getDoctrine()->getRepository('AppBundle:Records')->getCollection(
            $request->query->get('station'),
            $request->query->get('item', []),
            $this->getStartDateTime($request),
            $this->getEndDateTime($request),
            $request->query->has('last_24_hours')
        );
    }

    private function getDefaultRecords()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Records')->getCollection(
            25,
            [1, 2, 3, 4, 5, 6],
            (new \DateTime())->sub(new \DateInterval('P1D')),
            new \DateTime(),
            true
        );
    }

    private function getFilteredViewVars($request)
    {
        return [
            'selectedStation' => $request->query->get('station'),
            'selectedItemCollection' => $request->query->get('item', []),
            'selectedlast24Hours' => $request->query->has('last_24_hours'),
            'siteTitle' => $this->getTitle($request),
        ];
    }

    private function getDefaultViewVars()
    {
        return [
            'selectedStation' => 25,
            'selectedItemCollection' => [1, 2, 3, 4, 5, 6],
            'selectedlast24Hours' => true,
            'siteTitle' => null,
        ];
    }

    private function getViewVars($request, $records)
    {
        return [
            'records' => $records,
            'recordsForTable' => $this->getRecordsForTable($records),
            'stationCollection' => $this->getStationCollection(),
            'itemCollection' => $this->getItemCollection(),
            'routeName' => $request->get('_route'),
        ] + $this->getDateVars($request);
    }

    private function getDateVars($request)
    {
        return [
            'startDate' => $this->getStartDateTime($request),
            'endDate' => $this->getEndDateTime($request),
        ];
    }

    private function getStartDateTime($request)
    {
        if ($request->get('_route') == 'home' || $request->query->has('last_24_hours')) {
            return (new \DateTime())->sub(new \DateInterval('P1D'));
        } else {
            return ($request->query->get('start_date'))
                ? \DateTime::createFromFormat('d-m-Y', $request->query->get('start_date'))
                : \DateTime::createFromFormat('d-m-Y', '08-10-2015');
        }
    }

    private function getEndDateTime($request)
    {
        if ($request->get('_route') == 'home' || $request->query->has('last_24_hours')) {
            return new \DateTime();
        } else {
            return ($request->query->get('end_date'))
                ? \DateTime::createFromFormat('d-m-Y', $request->query->get('end_date'))
                : new \DateTime();
        }
    }

    private function getRecordsForTable($records)
    {
        $collection = [];
        foreach ($records as $itemId => $recordsByDate) {
            foreach ($recordsByDate as $date => $recordsByHour) {
                foreach ($recordsByHour as $hour => $record) {
                    $collection[$date][$hour][$itemId] = $record;
                }
            }
        }

        return $collection;
    }

    private function getTitle($request)
    {
        $siteTitle = $this->get('translator')->trans('home.filter_title.main').'. ';
        $siteTitle .= $this->getStationCollection()[$request->query->get('station')]->getName().'. ';
        if ($request->query->has('last_24_hours')) {
            $siteTitle .= $this->get('translator')->trans('home.filter_title.24hours').'. ';
        } elseif ($request->query->get('start_date') && $request->query->get('end_date')) {
            $siteTitle .= $request->query->get('start_date').' - '.$request->query->get('end_date').'. ';
        } elseif ($request->query->get('start_date')) {
            $siteTitle .= $this->get('translator')->trans('home.filter_title.from').' '.$request->query->get('start_date').'. ';
        } elseif ($request->query->get('end_date')) {
            $siteTitle .= $this->get('translator')->trans('home.filter_title.to').' '.$request->query->get('end_date').'. ';
        }
        $itemCollection = [];
        foreach ($request->query->get('item', []) as $itemId) {
            $itemCollection[] = $this->getItemCollection()[$itemId]->getName();
        }
        $siteTitle .= implode(', ', $itemCollection).'.';

        return $siteTitle;
    }

    private function getItemCollection()
    {
        if (!$this->itemCollection) {
            $this->itemCollection = $this->getDoctrine()->getRepository('AppBundle:Item')->getCollectionById();
        }

        return $this->itemCollection;
    }

    private function getStationCollection()
    {
        if (!$this->stationCollection) {
            $this->stationCollection = [];
            foreach ($this->getDoctrine()->getRepository('AppBundle:Station')->findAll() as $station) {
                $this->stationCollection[$station->getId()] = $station;
            }
        }

        return $this->stationCollection;
    }

    private function createHtmlFile($fileName, $content)
    {
        $fp = fopen($this->getFolderPath().$fileName.'.html', 'wb');
        fwrite($fp, $content);
        fclose($fp);
    }

    private function getFolderPath()
    {
        return $this->get('kernel')->getRootDir().'/../../../data/home/';
    }

    private function getUnrepeatedRandomFileName()
    {
        return rand(5, 1000000).'_'.preg_replace('/[^0-9]/', '', microtime(true));
    }
}
