<?php

class changeDomainItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'changeDomainItem';
    public $classKey = 'changeDomainItem';
    public $languageTopics = array('changedomain');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('changedomain_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('changedomain_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'changeDomainItemCreateProcessor';