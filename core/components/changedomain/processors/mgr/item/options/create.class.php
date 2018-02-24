<?php

class changeDomainOptionsCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'changeDomainOptions';
    public $classKey = 'changeDomainOptions';
    public $languageTopics = array('changedomain');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        if($this->getProperty('resource_id')){

            $validate = array(
                'name',
                //'domain_id',
                'key',
                'value'
            );

            foreach ($validate as $val){
                if(empty($this->getProperty($val))){
                    $this->modx->error->addField($val, $this->modx->lexicon('changedomain_item_err_key'));
                }elseif($this->modx->getCount($this->classKey, array(
                    'name' => $this->getProperty('name'),
                    'resource_id' => $this->getProperty('resource_id'),
                    'domain_id' => $this->getProperty('domain_id')))){
                    $this->modx->error->addField('name', $this->modx->lexicon('changedomain_item_err_ae'));
                }
            }
        }elseif($this->getProperty('domain_id') && !$this->getProperty('resource_id')){
            $name = trim($this->getProperty('name'));
            if (empty($name)) {
                $this->modx->error->addField('name', $this->modx->lexicon('changedomain_item_err_name'));
            } elseif ($this->modx->getCount($this->classKey, array('name' => $name, 'domain_id' => $this->getProperty('domain_id')))) {
                $this->modx->error->addField('name', $this->modx->lexicon('changedomain_item_err_ae'));
            }
        }
        return parent::beforeSet();
    }

}

return 'changeDomainOptionsCreateProcessor';