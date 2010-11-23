<?php
/**
*
* Copyright 2006-2009, David Lloyd, Lloydhome Consulting, Inc. (<a href="mailto:david@lloydhome.com">david@lloydhome.com</a>)
* Licensed under the Creative Commons Attribution-Share Alike 3.0 (<a href="http://creativecommons.org/licenses/by-sa/3.0/us/" title="http://creativecommons.org/licenses/by-sa/3.0/us/">http://creativecommons.org/licenses/by-sa/3.0/us/</a>)
*
* A Behavior class that handles Recursive Association queries.
*
* You can find more information at <a href="https://trac.cakephp.org/ticket/633
" title="https://trac.cakephp.org/ticket/633
">https://trac.cakephp.org/ticket/633
</a> *
* We have all been there. A simple query but the query condition is three
* joins away. Now I don't have to build a large custom query. Assume you
* have the models User, City, State, Area, Country, Region. Users are in a
* City. Cities are in a State. States are in an Area. Areas are in a Country.
* Countries are in a Region. How do you query for Users in a Country? Or
* Area? The query is simple but Cake has not supported it. This feature is
* listed as issue #633 in Trac.
*
* After discussing the matter with PHPNut in early 2007, we decided the method
* of navigation through the associations should be via :: operators. So to
* limit users by Country would be
*
* City::State::Area::Country.name
*
* A query using findAll would then be like
*
* $users = $this->User->find( 'all', aa('conditions',aa('City::State::Area::Country.name','Canada') ) );
*
* The query formed would look something like
*
    SELECT `User`.`id`,`User`.`name`,`User`.`email`,`User`.`city_id`,    
    `City`.`id`,`City`.`name`,`City`.`state_id`,   
    `City__x__State`.`id`,`City__x__State`.`name`,`City__x__State`.`area_id`,
    `City__x__State__x__Area`.`id`,`City__x__State__x__Area`.`name`,`City__x__State__x__Area`.`country_id`,
    `City__x__State__x__Area__x__Country`.`id`,`City__x__State__x__Area__x__Country`.`name`,`City__x__State__x__Area__x__Country`.`region_id`,
    FROM `users` AS `User`
    LEFT OUTER JOIN `cities` AS `City` ON `User`.`city_id`=`City`.`id`
    LEFT OUTER JOIN `states` AS `City__x__State` ON `City`.`state_id`=`City__x__State`.`id`
    LEFT OUTER JOIN `areas` AS `City__x__State__x__Area` ON `City__x__State`.`area_id`=`City__x__State__x__Area`.`id`
    LEFT OUTER JOIN `countries` AS `City__x__State__x__Area__x__Country` ON `City__x__State__x__Area`.`country_id`=`City__x__State__x__Area__x__Country`.`id`
    WHERE `City__x__State__x__Area__x__Country`.`name` = 'Canada'
*
* The results of this query gets transformed into a typical CakePHP resultset
*
    Array
    (
        [0] => Array
            (
                [User] => Array
                    (
                        [id] => 1
                        [name] => Joe
                        [email] => test@example.com
                        [city_id] => 1
                    )
                [City] => Array
                    (
                        [id] => 1
                        [name] => New York
                        [state_id] => 1
                        [State] => Array
                            (
                                [id] => 1
                                [name] => New York
                                [area_id] => 1
                                [Area] => Array
                                    (
                                        [id] => 1
                                        [name] => New York
                                        [country_id] => 1
                                        [Country] => Array
                                            (
                                                [id] => 1
                                                [name] => USA
                                            )
                                    )
                            )
                    )
            )
    )   
*
*/
class RecursiveAssociationBehavior extends ModelBehavior {

    var $cmds = null;
    var $recursiveLinkedModels = null;

    // You can change this but will need to change preg_match_all in _preprocess()
    const LINK_SEPARATOR = '::';
   
    // Feel free to change this to a unique separator, like '__xXx__'
    const LINK_JOIN = '____';

    public function __construct() {
    }

    function setup(&$model, $config = array()) {
    }
   
    public function beforeFind(&$Model, $query) {
        static $types = array('conditions', 'fields', 'order', 'group');

        $contain = array();

        // merge everyone into a lump and find containable relationships
        // a containable relationship will be rooted on an immediate relationship and be of the form
        //    X::Y.field or X::Y::Z.field, etc
        //    X must be defined as a belongsTo, hasOne, hasMany of this model
        //    Y must be defined as a belongsTo, hasOne, hasMany of X

        // while we allow tables to belongs to different configs, they must be in the same database
        $this->cmds = $cmds = ConnectionManager::getDataSource($Model->useDbConfig);

        $recursivePaths = array();

        foreach ($types as $type) {
            if (!empty($query[$type])) {
                foreach ((array)$query[$type] as $typekey => $typeval) {
               
                    $newkey = $this->_preprocess($type, $typekey, $query, $Model, $contain, $recursivePaths);

                    if ($newkey !== $typekey) {
                        unset($query[$type][$typekey]);
                        $query[$type][$newkey] = $typeval;
                        $typekey = $newkey;
                    }

                    $query[$type][$typekey] = $this->_preprocess($type, $typeval, $query, $Model, $contain, $recursivePaths);
                   
                }
            }
        }

        $this->recursiveLinkedModels = $recursivePaths;

        $query['joins'] = array_values($query['joins']);
       
        return $query;
    }
   
    public function afterFind(&$model, $results, $primary) {
       
        if ($primary && !empty($this->recursiveLinkedModels) && !empty($results)) {

            foreach ($this->recursiveLinkedModels as $recursiveItem) {
                $path = explode(RecursiveAssociationBehavior::LINK_SEPARATOR, $recursiveItem);
                $join_name = implode(RecursiveAssociationBehavior::LINK_JOIN, $path);
               
                if (isset($results[0][$join_name])) {
                    foreach ($results as $k => &$row) {
                        $pnode =& $node;
                        $node =& $row;
                        foreach ($path as $path_node) {
                            if (!isset($node[$path_node])) {
                                $node[$path_node] = array();
                            }
                            $pnode =& $node;
                            $node =& $node[$path_node];
                        }
                        $pnode[$path_node] = am($node, $row[$join_name]);
                        unset($row[$join_name]);
                    }
                    unset($row);
                }
            }

        }

        return $results;
    }


    function _preprocess($type, $items, &$query, &$Model, &$contain, &$recursivePaths, $path_prefix = '') {

        if (is_array($items)) {
            foreach ($items as $key => $item) {
                if (!is_numeric($key)) {
                    $newkey = $this->_preprocess($type, $key, $query, $Model, $contain, $recursivePaths, $path_prefix);
                    if ($newkey !== $key) {
                        unset($items[$key]);
                        $items[$newkey] = $item;
                        $key = $newkey;
                    }
                }
                $item = $this->_preprocess($type, $item, $query, $Model, $contain, $recursivePaths, $path_prefix);
                $items[$key] = $item;
            }
            return $items;
        } else {
            $item = $items;

            preg_match_all('/(?:[\'\"][^\'\"\\\]*(?:\\\.[^\'\"\\\]*)*[\'\"])|([\\:a-z0-9_' . $this->cmds->startQuote . $this->cmds->endQuote . ']*\\.[a-z0-9_' . $this->cmds->startQuote . $this->cmds->endQuote . ']*)/i',
                            $item,
                            $itemMatches,
                            PREG_PATTERN_ORDER);
            if (isset($itemMatches['1']['0'])) {
                $pregCount = count($itemMatches['1']);

                $SEPARATOR = RecursiveAssociationBehavior::LINK_SEPARATOR;
                $JOINER = RecursiveAssociationBehavior::LINK_JOIN;
           
                for ($i = 0; $i < $pregCount; $i++) {
                    if (!empty($itemMatches['1'][$i]) && !is_numeric($itemMatches['1'][$i])) {
                        $fld = $itemMatches['1'][$i];
                        $parts = explode('.', $fld);
                        if (count($parts) == 2) {
                            $alias = $parts[0];
                           
                            if (!empty($path_prefix) && array_key_exists($alias, $recursivePaths)) {
                                $use_prefix = true;
                            } else {
                                $use_prefix = false;
                            }
                           
                            // looks good, get the relationships
                            $rels = explode(RecursiveAssociationBehavior::LINK_SEPARATOR, ($use_prefix ? $path_prefix : '') . $alias);
                           
                            // is it recursive?
                            if (count($rels) < 2)
                                continue;
                           
                            $prefix_count = count(array_diff( explode(RecursiveAssociationBehavior::LINK_SEPARATOR, $path_prefix), array(' ','',null)));

                            // go ahead and replace the link string with the join string
                            $join = implode(RecursiveAssociationBehavior::LINK_JOIN, $rels);
                            $item = str_replace($alias, $join, $item);

                            $containedModel =& $Model;
                            $contained =& $contain;

                            for ($i=$prefix_count; $i < count($rels); $i++) {
                           
                                $rel_type = null;
                               
                                if (array_key_exists($rels[$i], $containedModel->belongsTo)) {
                                    $rel_type = 'belongsTo';
                                } elseif (array_key_exists($rels[$i], $containedModel->hasOne)) {
                                    $rel_type = 'hasOne';
                                } elseif (array_key_exists($rels[$i], $containedModel->hasMany)) {
                                    $rel_type = 'hasMany';
                                } else {
                                    $this->cake_error();
                                }

                                $assocData = $containedModel->{$rel_type}[$rels[$i]];
                                $external = isset($assocData['external']);

                                if (!isset($contained[$rels[$i]])) {

                                    $recursivePaths[ $rels[$i] ] = implode($SEPARATOR,array_slice($rels,0,$i+1));
                                   
                                    $contained[$rels[$i]] = array();

                                    $oldAssocData = $assocData;

                                    $recursive = $containedModel->recursive;
                                    $alias = $containedModel->alias;
                                    $containedModel->recursive = -1;
                                    if ($i > 0)
                                        $containedModel->alias = implode($JOINER,array_slice($rels,0,$i));

                                    if (!empty($assocData['conditions'])) {
                                        if (!is_array($assocData['conditions']))
                                            $assocData['conditions'] = array($assocData['conditions']);
                                        $assocData['conditions'] = $this->_preprocess('conditions', $assocData['conditions'], $query, $containedModel, $contain, $recursivePaths,
                                                                                        implode($SEPARATOR, am(array_slice($rels,0,$i),'')) );
                                    }

                                    $result = $this->cmds->generateAssociationQuery($containedModel, $containedModel->{$rels[$i]}, $rel_type=='hasMany'?'hasOne':$rel_type, implode($JOINER,array_slice($rels,0,$i+1)), $assocData, $query, $external, $null);
                                    $containedModel->recursive = $recursive;
                                    $containedModel->alias = $alias;

                                    if (is_string($result)) {
                                        $result = str_replace('{$__cakeID__$}', implode($JOINER,array_slice($rels,0,$i)) . '.' . $containedModel->primaryKey, $result);
                                        $result = str_replace('{$__cakeForeignKey__$}', implode($JOINER,array_slice($rels,0,$i+1)) . '.' . $assocData['foreignKey'], $result);
                                        $queryData['joins'][] = " ,($result) {$this->alias} $assoc ";
                                    }

                                    $assocData = $oldAssocData;

                                }
                               
                                $contained =& $contained[$rels[$i]];
                                $containedModel =& $containedModel->{$rels[$i]};
                            }

                        }
                    }
                }
            }

            return $item;
        }
    }

}
?>