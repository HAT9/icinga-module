<?php

namespace Icinga\Module\Testmodule\Forms\Bio;

use Icinga\Forms\ConfigForm;

class BioinfoForm extends ConfigForm
{
    // public function init()
    // {
    //     $this->setName('Bio_Trace9');
    //     $this->setSubmitLabel($this->translate('Save Bio Info'));
    // }

    public function createElements(array $formData)
    {
        $this->addElements([
            [
                'text',
                'first_name',
                [
                    'required'      => true,
                    'label'         => $this->translate('First Name'),
                    'description'   => $this->translate('Your First Name'),
                ]
            ],
            [
                'text',
                'last_name',
                [
                    'required' => true,
                    'label'         => $this->translate('Last Name'),
                    'description'   => $this->translate(
                        'Your Last Name'
                    )
                ]
            ],
            [
                'text',
                'email',
                [
                    'renderEmail'    => true,
                    'label'             => $this->translate('Email'),
                    'description'       => $this->translate('Your Email Address'),
                    'required' => true
                ]
            ],
            [
                'text',
                'phn_number',
                [
                    // 'renderPhn'    => true,
                    'label'             => $this->translate('Phone Number'),
                    'description'       => $this->translate('Your Phone Number'),
                    'required' => true
                ]
            ],
            [
                'text',
                'cnic',
                [
                    // 'renderEmail'    => true,
                    'label'             => $this->translate('CNIC'),
                    'description'       => $this->translate('Your CNIC Number'),
                    'required' => true
                ]
            ],
            [
                'text',
                'address',
                [
                    // 'renderEmail'    => true,
                    'label'             => $this->translate('Address'),
                    'description'       => $this->translate('Your Residental Address'),
                    'required' => true
                ]
            ],

        ]);
        $this->setSubmitLabel('Add Bio Info');
       $this->setProgressLabel($this->translate('Adding'));
       $this->setAction("/icingaweb2/testmodule/bio/addbioinfo")->setMethod('post');        
    }
}
