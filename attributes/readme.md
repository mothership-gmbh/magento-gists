# 

## Get all attribute values and options by sku

* You want to get all entity attributes by sku
* You also want to get static values , not only EAV tables
* Pretty complex SQL query. Also handles the various INT/SELECT combinations

[SQL](./all_attributes_by_sku.sql)

## Get all attribute values and options

* You want to know which option values exist
* You only care about type_id = 4

[SQL](./all_attribute_values_and_options.sql)


## Get all attributes by attribute set

* You want to know which attributes belong to an attribute set
* You want to create a new simple product and don't know which fields are required (is_required=1)

[SQL](./all_attribute_by_attribute_set.sql)

## VIEW for all attributes and values by options

* You want to have a view which contains all product information
* Based on three views because VIEWS must not depend on SUBSELECTs.

[SQL](./view_all_attributes_by_sku.sql)
