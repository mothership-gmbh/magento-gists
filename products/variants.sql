# Get a view for all variants

CREATE table ms_variants AS CREATE VIEW  SELECT DISTINCT(o . value) AS variant_id,
                               stock . qty   AS stock,
                               label . value AS label,
                               price . value AS price,
                               special_price . value as special_price,
                               ean . value AS ean,
                               variant . entity_id AS simple,
                               l . parent_id
                FROM   catalog_product_entity_int variant
                       JOIN eav_attribute a
                         ON a . attribute_id = variant . attribute_id
                       JOIN eav_attribute_option_value o
                         ON o . option_id = variant . value
                       JOIN catalog_product_super_link l
                         ON variant . entity_id = l . product_id
                       LEFT JOIN cataloginventory_stock_status stock
                         ON stock . product_id = l . product_id
                       LEFT JOIN catalog_product_entity_varchar ean
                         ON ean . attribute_id = 141
            AND ean . entity_id = l . product_id
                       LEFT JOIN catalog_product_entity_varchar label
                         ON label . attribute_id = 139
            AND label . entity_id = l . product_id
                       LEFT JOIN catalog_product_entity_decimal price
                         ON price . attribute_id = 75
            AND price . entity_id = l . parent_id
                       LEFT JOIN catalog_product_entity_decimal special_price
                         ON special_price . attribute_id = 76
            AND special_price . entity_id = l . parent_id
                WHERE  a . attribute_code = 'variant'
            AND label . store_id = 1 ORDER BY l . parent_id, l . product_id
