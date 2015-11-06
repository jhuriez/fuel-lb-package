<?php

namespace Lb;

class Collection
{

    /**
     * Helper for manage collection in a object with "has_many" relationship
     * 
     * a POST example :
     * 
     * - For new object
     * $_POST['collection_name']['new']['uniq_id']['attribute_name']
     * 
     * - For existing object
     * $_POST['collection_name']['id']['attibute_name']
     * 
     * @param object $parentObject
     * @param string $collectionClassName
     * @param string $collectionName
     * @param bool $updateCollection If we can edite the object
     * @param bool $isUpdate It's an update or create ? (Form)
     * @param bool $deleteObject If we delete the object or just remove the relationship if he's not in the collection
     * @param array $attributes Attributes of object in collection
     *              array('libelle', 'price');
     *              array('libelle', 'price' => array('float')) // Do the function 'float' on the attribute price
     *              array('libelle', 'price' => array('changeName' => 'new_price_name')) // Do the function 'changeName' with argument 'new_price_name'
     *              array('libelle', 'price' => array('float', 'changeName' => 'new_price_name')) // Do both function
     * @param mixed $container the container ($_POST) by default
     * @param string $isNewElement The new element identifier
     * @return array
     */
    public static function manage($parentObject, $collectionClassName, $collectionName, $updateCollection = false, $isUpdate = false, $deleteObject = false, $attributes = array(), $container = null, $isNewElement = 'is_new_element')
    {
        $container = (is_array($container)) ? $container : \Input::post();

        $objectsToDelete = array();
        $objectsKey = array_keys($parentObject->{$collectionName});

        ////////////
        // UPDATE //
        ////////////
        if ($isUpdate)
        {
            foreach ($objectsKey as $objectId)
            {
                if (\Arr::get($container, $collectionName.'.'.$objectId) === null)
                {
                    // Delete the object
                    $deleteObject and $objectsToDelete[] = $parentObject->{$collectionName}[$objectId];
                    unset($parentObject->{$collectionName}[$objectId]);
                }
                else if ($updateCollection)
                {
                    // Update the object
                    $fromArray = array();
                    foreach ($attributes as $attributeKey => $attribute)
                    {
                        if (!is_array($attribute))
                        {
                            $attributeValue = \Arr::get($container, $collectionName.'.'.$objectId.'.'.$attribute);
                            $fromArray[$attribute] = $attributeValue;
                        }
                        // Do Function
                        else
                        {
                            $attributeValue = \Arr::get($container, $collectionName.'.'.$objectId.'.'.$attributeKey);

                            // Use attribute key as attribute
                            if (array_key_exists('newName', $attribute))
                            {
                                $attributeKey = $attribute['newName'];
                            }
                            $fromArray[$attributeKey] = static::doFunction($attributeValue, $attribute);
                        }
                    }
                    $parentObject->{$collectionName}[$objectId]->from_array($fromArray);
                }
            }
        }

        /////////////////
        // NEW ELEMENT //
        /////////////////

        // Fetch the POST
        $collectionPost = (\Arr::get($container, $collectionName)) ? : array();

        // Fetch all new element
        foreach ($collectionPost as $k => $v)
        {
            if ($k != 'new' && isset($v[$isNewElement]) && $v[$isNewElement] == '1')
            {
                $collectionPost['new'][$k] = $v;
                unset($collectionPost[$k]);
            }
        }
        
        foreach ($collectionPost as $k => $v)
        {
            // If create the collection object
            if ($k == 'new')
            {
                foreach($v as $objectPost) {
                    $fromArray = array();
                    foreach ($attributes as $attributeKey => $attribute)
                    {
                        if (!is_array($attribute)) 
                        {
                            $attributeValue = isset($objectPost[$attribute]) ? $objectPost[$attribute] : null;
                            $fromArray[$attribute] = $attributeValue;
                        }
                        // Do Function
                        else
                        {
                            $attributeValue = isset($objectPost[$attributeKey]) ? $objectPost[$attributeKey] : null;

                            // Use attribute key as attribute
                            if (array_key_exists('newName', $attribute))
                            {
                                $attributeKey = $attribute['newName'];
                            }
                            $fromArray[$attributeKey] = static::doFunction($attributeValue, $attribute);
                        }
                    }
                    $object = call_user_func(array($collectionClassName, 'forge'), $fromArray);
                    $parentObject->{$collectionName}[] = $object;
                }
            }
            // Or add a relationship
            else
            {
                if (is_numeric($k) && !in_array($k, $objectsKey))
                {
                    $object = call_user_func(array($collectionClassName, 'find'), $k);
                    $parentObject->{$collectionName}[] = $object;
                }
            }
        }

        if ($deleteObject)
        {
            return array(
                $parentObject,
                $objectsToDelete,
            );
        }
        else
        {
            return $parentObject;
        }
    }

    
    public static function doFunction($value, $function)
    {
        foreach($function as $nameFunction => $arg)
        {
            is_numeric($nameFunction) and $nameFunction = $arg;

            switch($nameFunction)
            {
                case 'explode':
                    $value = explode($arg, $value);
                break;

                case 'stripslashes':
                    $value = stripslashes($value);
                break;

                case 'int':
                    $value = (int)$value;
                break;

                case 'float':
                    $dotPos = strrpos($value, '.');
                    $commaPos = strrpos($value, ',');
                    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : 
                        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
                   
                    if (!$sep) {
                        return floatval(preg_replace("/[^0-9]/", "", $value));
                    } 

                    $value = floatval(
                        preg_replace("/[^0-9]/", "", substr($value, 0, $sep)) . '.' .
                        preg_replace("/[^0-9]/", "", substr($value, $sep+1, strlen($value)))
                    );
                break;

                case 'bool':
                case 'boolean':
                    if ($value == 'true') $value = true;
                    else if ($value == '1') $value = true;
                    else if ($value == 'false') $value = false;
                    else if ($value == '0') $value = false;
                    else $value = (boolean)$value;
                break;

                case 'date':
                    if ($value == '' || $value == null) $value = null;
                    else $value = \Date::create_from_string($value, 'eu')->format('mysql');
                break;

                case 'date_day_include':
                    if ($value == '' || $value == null) $value = null;
                    else $value = \Date::forge(\Date::create_from_string($value, 'eu')->get_timestamp() + 86399)->format('mysql');
                break;
            }
        }

        return $value;
    }


    public static function getPrototypeVars($object, $args)
    {
        $resArray = array();

        ///////////////
        // For isNew //
        ///////////////
        
        // Set object or variable to get result
        if (isset($args['toCheck']))
        {
            $toCheck = $args['toCheck'];
        }
        else
        {
            $toCheck = $object;
        }

        $resArray['new'] = (isset($toCheck->id)) ? '0' : '__isNew__';

        ////////////////
        // Parse Args //
        ////////////////
        foreach($args as $varName => $options)
        {

            if (is_numeric($varName))
            {
                $varName = $options;
            }

            // Set object or variable to get result
            if (isset($options['toCheck']))
            {
                $toCheck = $options['toCheck'];
            }
            else
            {
                $toCheck = $object;
            }

            // Set object or variable to get result
            if (isset($options['toResult']))
            {
                $toResult = $options['toResult'];
            }
            else
            {
                $toResult = $object;
            }

            // If exist
            if (isset($toCheck->id))
            {
                if (isset($options['return']))
                {
                    switch($options['return']['type'])
                    {
                        case 'function':
                            $res = $toResult->{$options['return']['value']}();
                        break;

                        case 'checkbox':
                            $res = ($toResult->{$varName}) ? ' checked="checked"' : '';
                        break;
                    }
                }
                else
                {
                    $res = $toResult->{$varName};
                }
            }
            // New object
            else
            {
                $res = '__'.$varName.'__';
            }

            $resArray[$varName] = $res;

        }

        return $resArray;
    }
}