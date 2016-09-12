# Find all products which are not visible

```
SELECT 
cpe.entity_id, cpe.sku, cpe.type_id,
cpei.`attribute_id`, cpei.value,
ea.attribute_code
FROM catalog_product_entity cpe
JOIN catalog_product_entity_int cpei ON cpe.`entity_id` = cpei.`entity_id`
JOIN eav_attribute ea ON ea.`attribute_id` = cpei.`attribute_id`
WHERE attribute_code='visibility'
AND cpe.type_id='simple'
AND cpei.value != 1
;

# VISIBILITY_NOT_VISIBLE = 1
# VISIBILITY_IN_CATALOG  = 2 
# VISIBILITY_IN_SEARCH   = 3
# VISIBILITY_BOTH 		 = 4 
```
