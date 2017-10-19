<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('changedomain_core_path', null,
                    $modx->getOption('core_path') . 'components/changedomain/') . 'model/';
            $modx->addPackage('changedomain', $modelPath);

            $manager = $modx->getManager();
            $objects = array();
            $schemaFile = MODX_CORE_PATH . 'components/changedomain/model/schema/changedomain.mysql.schema.xml';
            if (is_file($schemaFile)) {
                $schema = new SimpleXMLElement($schemaFile, 0, true);
                if (isset($schema->object)) {
                    foreach ($schema->object as $obj) {
                        $objects[] = (string)$obj['class'];
                    }
                }
                unset($schema);
            }
            foreach ($objects as $tmp) {
                $table = $modx->getTableName($tmp);
                $sql = "SHOW TABLES LIKE '" . trim($table, '`') . "'";
                $stmt = $modx->prepare($sql);
                $newTable = true;
                if ($stmt->execute() && $stmt->fetchAll()) {
                    $newTable = false;
                }
                // If the table is just created
                if ($newTable) {
                    $manager->createObjectContainer($tmp);
                } else {
                    // If the table exists
                    // 1. Operate with tables
                    $tableFields = array();
                    $c = $modx->prepare("SHOW COLUMNS IN {$modx->getTableName($tmp)}");
                    $c->execute();
                    while ($cl = $c->fetch(PDO::FETCH_ASSOC)) {
                        $tableFields[$cl['Field']] = $cl['Field'];
                    }
                    foreach ($modx->getFields($tmp) as $field => $v) {
                        if (in_array($field, $tableFields)) {
                            unset($tableFields[$field]);
                            $manager->alterField($tmp, $field);
                        } else {
                            $manager->addField($tmp, $field);
                        }
                    }
                    foreach ($tableFields as $field) {
                        $manager->removeField($tmp, $field);
                    }
                    // 2. Operate with indexes
                    $indexes = array();
                    $c = $modx->prepare("SHOW INDEX FROM {$modx->getTableName($tmp)}");
                    $c->execute();
                    while ($cl = $c->fetch(PDO::FETCH_ASSOC)) {
                        $indexes[$cl['Key_name']] = $cl['Key_name'];
                    }
                    foreach ($modx->getIndexMeta($tmp) as $name => $meta) {
                        if (in_array($name, $indexes)) {
                            unset($indexes[$name]);
                        } else {
                            $manager->addIndex($tmp, $name);
                        }
                    }
                    foreach ($indexes as $index) {
                        $manager->removeIndex($tmp, $index);
                    }
                }
            }
            break;

        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
