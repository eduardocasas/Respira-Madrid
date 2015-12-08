<?php

namespace AppBundle\Controller\home;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    private $stationCollection;
    private $itemCollection;
    
    public function getFileAction($fileName)
    {
        $filepath = $this->getFolderPath().$fileName.'.pdf';
        $response = new Response;
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filepath));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($filepath).'";');
        $response->headers->set('Content-length', filesize($filepath));
        $response->sendHeaders();
        $fileContent = readfile($filepath);
        unlink($filepath);
        
        return $response->setContent($fileContent);
    }

    public function printAction()
    {
        $content = $this->renderView('home/index.html.twig', ['printFile' => true]+(($this->container->get('request')->get('_route') == 'home_print')
            ? $this->getViewVars($this->getDefaultRecords())+$this->getDefaultViewVars()
            : $this->getViewVars($this->getFilteredRecords())+$this->getFilteredViewVars()
        ));
        $fileName = $this->getUnrepeatedRandomFileName();
        $this->createHtmlFile($fileName, $content);
        shell_exec('cd '.$this->getFolderPath().' && xvfb-run --auto-servernum --server-num=1 -a wkhtmltopdf '.$fileName.'.html '.$fileName.'.pdf');
        unlink($this->getFolderPath().$fileName.'.html');
        
        return new JsonResponse(
            ['url' => $this->generateUrl('home_print_get_file', ['fileName' => $fileName])]
        );
    }
    
    public function filterAction()
    {
        $records = $this->getFilteredRecords();

        return ($this->getRequest()->isXmlHttpRequest())
            ? $this->render('home/records.html.twig', $this->getDateVars()+[
                'records' => $records,
                'recordsForTable' => $this->getRecordsForTable($records),
                'selectedStation' => $this->getRequest()->query->get('station'),
                'stationCollection' => $this->getStationCollection(),
                'itemCollection' => $this->getDoctrine()->getRepository('AppBundle:Item')->getCollectionById(),
                'selectedlast24Hours' => $this->getRequest()->query->has('last_24_hours'),
                'siteTitle' => $this->getTitle()
            ])
            : $this->render('home/index.html.twig', $this->getViewVars($records)+$this->getFilteredViewVars()+[
                'section' => 'home'
            ]);
    }

    public function indexAction()
    {
        return $this->render('home/index.html.twig', $this->getViewVars($this->getDefaultRecords())+$this->getDefaultViewVars()+[
            'section' => 'home'
        ]);
    }
    
    private function getFilteredRecords()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Records')->getCollection(
            $this->getRequest()->query->get('station'),
            $this->getRequest()->query->get('item', []),
            $this->getStartDateTime(),
            $this->getEndDateTime(),
            $this->getRequest()->query->has('last_24_hours')
        );
    }
    
    private function getDefaultRecords()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Records')->getCollection(
            25,
            [1, 2, 3, 4, 5, 6],
            (new \DateTime)->sub(new \DateInterval('P1D')),
            new \DateTime,
            true
        );
    }
    
    private function getFilteredViewVars()
    {
        return [
            'selectedStation' => $this->getRequest()->query->get('station'),
            'selectedItemCollection' => $this->getRequest()->query->get('item', []),
            'selectedlast24Hours' => $this->getRequest()->query->has('last_24_hours'),
            'siteTitle' => $this->getTitle()
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
    
    private function getViewVars($records)
    {
        return [
            'records' => $records,
            'recordsForTable' => $this->getRecordsForTable($records),
            'stationCollection' => $this->getStationCollection(),
            'itemCollection' => $this->getItemCollection(),
            'routeName' => $this->getRequest()->get('_route')
        ]+$this->getDateVars();
    }    
    
    private function getDateVars()
    {
        return [
            'startDate' => $this->getStartDateTime(),
            'endDate' => $this->getEndDateTime()
        ];
    }
    
    private function getStartDateTime()
    {
        if ($this->container->get('request')->get('_route') == 'home' || $this->getRequest()->query->has('last_24_hours')) {
            return (new \DateTime)->sub(new \DateInterval('P1D'));
        } else {
            return ($this->getRequest()->query->get('start_date')) 
                ? \DateTime::createFromFormat('d-m-Y', $this->getRequest()->query->get('start_date'))
                : \DateTime::createFromFormat('d-m-Y', '08-10-2015');
        }
    }
    
    private function getEndDateTime()
    {
        if ($this->container->get('request')->get('_route') == 'home' || $this->getRequest()->query->has('last_24_hours')) {
            return new \DateTime;
        } else {
            return ($this->getRequest()->query->get('end_date')) 
                ? \DateTime::createFromFormat('d-m-Y', $this->getRequest()->query->get('end_date'))
                : new \DateTime;
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
    
    private function getTitle()
    {
        $siteTitle = $this->get('translator')->trans('home.filter_title.main').'. ';
        $siteTitle .= $this->getStationCollection()[$this->getRequest()->query->get('station')]->getName().'. ';        
        if ($this->getRequest()->query->has('last_24_hours')) {
            $siteTitle .= $this->get('translator')->trans('home.filter_title.24hours').'. ';
        } elseif ($this->getRequest()->query->get('start_date') && $this->getRequest()->query->get('end_date')) {
            $siteTitle .= $this->getRequest()->query->get('start_date').' - '.$this->getRequest()->query->get('end_date').'. ';
        } elseif ($this->getRequest()->query->get('start_date')) {
            $siteTitle .= $this->get('translator')->trans('home.filter_title.from').' '.$this->getRequest()->query->get('start_date').'. ';
        } elseif ($this->getRequest()->query->get('end_date')) {
            $siteTitle .= $this->get('translator')->trans('home.filter_title.to').' '.$this->getRequest()->query->get('end_date').'. ';
        }
        $itemCollection = [];
        foreach ($this->getRequest()->query->get('item', []) as $itemId) {
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
        $fp = fopen($this->getFolderPath().$fileName.'.html', "wb");
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
