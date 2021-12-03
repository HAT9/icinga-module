<?php

namespace Icinga\Module\Testmodule\Controllers;

use Icinga\Application\Config;
use Icinga\Module\Testmodule\Forms\Bio\BioinfoForm;
use Icinga\Exception\ConfigurationError;
use Icinga\Web\Url;
use Icinga\Module\Director\Db;
use lipl\Pagination\Adapter\SqlAdapter;
use lipl\Pagination\Paginator;
use ipl\Sql;
use Icinga\Data\ResourceFactory;
use PDO;
use Icinga\Module\Testmodule\SortAdapter;
use Icinga\Module\Testmodule\FilterAdapter;
use Icinga\Module\Testmodule\SqlFilter;
// use ;
class BioController extends \Icinga\Web\Controller
{
    public function init()
    {
        $this->assertPermission('config/modules');
        parent::init();
    }


    protected function getDb()
    {
        
        $config = new Sql\Config(ResourceFactory::getResourceConfig(
            $this->Config()->get('db', 'resource')
        ));

        $config->options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET SESSION SQL_MODE='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE"
                . ",ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'"
        ];

        $conn = new Sql\Connection($config);

        return $conn;
    }



    public function bioinfoAction()
    {
        
        $this->view->form = $form = new BioinfoForm();
        $form->setIniConfig($this->Config())->handleRequest();
    }

    public function addbioinfoAction(){
        // $dbResourceName = Config::module('director')->get('db', 'resource');
        // $connection = Db::fromResourceName($dbResourceName);
        // $directordb = $connection->getDbAdapter();
        
        try {
            $conn = $this->getDb();
        } catch (ConfigurationError $_) {
            $this->render('missing-resource', null, true);
            return;
        }
        // $conn->query($sql);
        $conn->insert(
            'bioinfo',
            array(
                'firstname'       => $_POST['first_name'],
                'lastname'       => $_POST['last_name'],
                'email'       => $_POST['email'],
                'cnic'       => $_POST['cnic'],
                'phn_number'       => $_POST['phn_number'],
                'residental_address'       => $_POST['address'],
              
            )
        );
        $this->getResponse()->setRedirect('/icingaweb2/testmodule/bio/list');

    } 

    public function listAction(){

        try {
            $conn = $this->getDb();
        } catch (ConfigurationError $_) {
            $this->render('missing-resource', null, true);
            return;
        }
        $select = (new Sql\Select())
        ->from('bioinfo c')
        ->columns([
            'c.firstname',
            'c.lastname',
            'c.email',
            'c.cnic',
            'c.phn_number',
            'c.residental_address',
        ]);

        $this->view->paginator = new Paginator(new SqlAdapter($conn, $select), Url::fromRequest());

        $sortAndFilterColumns = [
            'firstname' => $this->translate('FirstName'),
            'lastname' => $this->translate('LastName'),
            'email' => $this->translate('CNIC'),
            'cnic' => $this->translate('Email'),
            'phn_number' => $this->translate('Phone Number'),
            'residental_address' => $this->translate('Address'),
            
        ];

        $this->setupSortControl(
            $sortAndFilterColumns,
            new SortAdapter($select)
        );
        $this->setupLimitControl();

        $filterAdapter = new FilterAdapter();
        $this->setupFilterControl(
            $filterAdapter,
            $sortAndFilterColumns,
            ['firstname','lastname','email','cnic']
        );
        SqlFilter::apply($select, $filterAdapter->getFilter());

        // print_r($select);
        $this->view->list = $conn->select($select);
    }
}