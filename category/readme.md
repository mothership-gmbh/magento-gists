# 

## A custom SQL function to get the full Magento path as a string

```
SELECT MS_GET_CATEGORY_PATH(30, 2, 2, TRUE)
```

* You want to get the Magento path as a string
* You want to have the string language specific

Example use case "get all categories and paths"

```
SELECT MS_GET_CATEGORY_PATH(30, 2, 2, TRUE);

SELECT cce.entity_id, path, MS_GET_CATEGORY_PATH(cce.entity_id, 1, 2, TRUE) AS path_string,
t_s.value 
FROM catalog_category_entity cce
LEFT JOIN catalog_category_entity_varchar AS t_s
 ON (t_s.attribute_id = 41 AND t_s.store_id = 1 AND t_s.entity_id = cce.entity_id)
```


[SQL](./fn_category_path.sql)
