#
# You want to delete all items in the database which does not have a qty, for example for debugging
# In this case delete all simple items without qty first
#
DELETE cpe FROM catalog_product_entity
LEFT JOIN cataloginventory_stock_item csi ON cpe.entity_id = csi.product_id
WHERE type_id = 'simple'
AND qty = 0;

#
# In the next step we will remove all parent items which does not have any simples
# associated
#
DELETE cpe FROM catalog_product_entity cpe
LEFT JOIN catalog_product_super_link cpsl ON cpe.`entity_id` = cpsl.`parent_id`
WHERE cpsl.`product_id` IS NULL;