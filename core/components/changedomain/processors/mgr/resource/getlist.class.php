<?php


class changeDomainOptionsGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'changeDomainOptions';
    public $classKey = 'changeDomainOptions';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {

        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where(array(
                'name:LIKE' => "%{$query}%",
                'OR:key:LIKE' => "%{$query}%",
            ));
        }

        $c->where(array(
            'resource_id' => $this->getProperty('resource_id')
        ));

//        $c->innerJoin('changeDomainItem', 'changeDomainItem', 'changeDomainOptions.domain_id = changeDomainItem.id');
//        $c->select($this->modx->getSelectColumns('changeDomainOptions', 'changeDomainOptions'));
//        $c->select('changeDomainItem.name as domain_id');

//        $c->prepare();
//        $this->modx->log(MODX_LOG_LEVER_ERROR, $c->toSQL());


        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = array();


        // Remove
        $array['actions'][] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('changedomain_option_remove'),
            'multiple' => $this->modx->lexicon('changedomain_options_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        );

        return $array;
    }

}

return 'changeDomainOptionsGetListProcessor';