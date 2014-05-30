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
     * @return array
     */
    public static function manage($parentObject, $collectionClassName, $collectionName, $updateCollection = false, $isUpdate = false, $deleteObject = false, $attributes = array())
    {
        $objectsToDelete = array();
        $objectsKey = array_keys($parentObject->{$collectionName});

        if ($isUpdate)
        {
            foreach ($objectsKey as $objectId)
            {
                if (\Input::post($collectionName.'.'.$objectId) === null)
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
                            $fromArray[$attribute] = \Input::post($collectionName.'.'.$objectId.'.'.$attribute);
                        }
                        else
                        {
                            $fromArray[$attributeKey] = static::doFunction(\Input::post($collectionName.'.'.$objectId.'.'.$attributeKey), $attribute);
                        }
                    }
                    $parentObject->{$collectionName}[$objectId]->from_array($fromArray);
                }
            }
        }

        // Fetch the POST
        $collectionPost = (\Input::post($collectionName)) ? : array();
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
                            $fromArray[$attribute] = $objectPost[$attribute];
                        }
                        else
                        {
                            $fromArray[$attributeKey] = static::doFunction($objectPost[$attributeKey], $attribute);
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
        switch($function[0])
        {
            case 'explode':
                return explode($function[1], $value);
            break;
        }
    }
}