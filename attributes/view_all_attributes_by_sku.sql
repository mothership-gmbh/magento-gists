# VIEW all_attributes

CREATE VIEW view_attributes AS
SELECT eaov.option_id,
       eao.attribute_id,
       eaov.value,
       eaov.store_id
FROM   eav_attribute_option eao
       LEFT JOIN eav_attribute_option_value eaov
              ON eao.option_id = eaov.option_id;
              
# VIEW view_all


CREATE VIEW view_all AS
SELECT         ce.entity_id,
		 cpsl.parent_id,
               ce.sku,
               ea.attribute_id,
               ea.attribute_code,
               ea.frontend_input,
               ea.backend_type,
               e_eaov.`option_id`,
               CASE ea.backend_type
                 WHEN 'varchar' THEN ce_varchar.value
                 WHEN 'int' THEN ce_int.value
                 WHEN 'text' THEN ce_text.value
                 WHEN 'decimal' THEN ce_decimal.value
                 WHEN 'datetime' THEN ce_datetime.value
               END            AS `value`,
               
               e_eaov.value   AS option_value,
               
               CASE ea.backend_type
                 WHEN 'VARCHAR' THEN ce_varchar.value
                 WHEN 'INT' THEN
                 	CASE
                 		WHEN e_eaov.value IS NULL THEN ce_int.value ELSE e_eaov.value 
                 	END
                 WHEN 'TEXT' THEN ce_text.value
                 WHEN 'DECIMAL' THEN ce_decimal.value
                 WHEN 'DATETIME' THEN ce_datetime.value
               END            AS `combined`,
               CASE ea.backend_type
                 WHEN 'VARCHAR' THEN ce_varchar.store_id
                 WHEN 'INT' THEN ce_int.store_id
                 WHEN 'TEXT' THEN ce_text.store_id
                 WHEN 'DECIMAL' THEN ce_decimal.store_id
                 WHEN 'DATETIME' THEN ce_datetime.store_id
               END            AS store_id,
               ea.is_required AS required
        FROM   catalog_product_entity AS ce
               LEFT JOIN eav_attribute AS ea
                      ON ce.entity_type_id = ea.entity_type_id
               LEFT JOIN catalog_product_entity_varchar AS ce_varchar
                      ON ce.entity_id = ce_varchar.entity_id
                         AND ea.attribute_id = ce_varchar.attribute_id
                         AND ea.backend_type = 'VARCHAR'
               LEFT JOIN catalog_product_entity_int AS ce_int
                      ON ce.entity_id = ce_int.entity_id
                         AND ea.attribute_id = ce_int.attribute_id
                         AND ea.backend_type = 'INT'
               LEFT JOIN catalog_product_entity_text AS ce_text
                      ON ce.entity_id = ce_text.entity_id
                         AND ea.attribute_id = ce_text.attribute_id
                         AND ea.backend_type = 'TEXT'
               LEFT JOIN catalog_product_entity_decimal AS ce_decimal
                      ON ce.entity_id = ce_decimal.entity_id
                         AND ea.attribute_id = ce_decimal.attribute_id
                         AND ea.backend_type = 'DECIMAL'
               LEFT JOIN catalog_product_entity_datetime AS ce_datetime
                      ON ce.entity_id = ce_datetime.entity_id
                         AND ea.attribute_id = ce_datetime.attribute_id
                         AND ea.backend_type = 'DATETIME'
               LEFT JOIN view_attributes e_eaov
                      ON e_eaov.`option_id` = ce_int.`VALUE`
                         AND e_eaov.`store_id` = ce_int.`store_id`
                         AND e_eaov.attribute_id = ea.attribute_id
               LEFT JOIN catalog_product_super_link cpsl ON ce.entity_id = cpsl.product_id;
