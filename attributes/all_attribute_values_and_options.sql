 SELECT ea.attribute_id,
                   ea.backend_type,
                   ea.frontend_input,
                   ea.attribute_code,
                   ea.source_model,
                   ea.default_value,
                   ea.entity_type_id,
                   ea.is_user_defined,
                   eao.option_id,
                   cs.code AS store_code,
                   eaov.store_id,
                   eaov.value
            FROM   eav_attribute ea
                   LEFT JOIN eav_attribute_option eao
                          ON eao.attribute_id = ea.attribute_id
                   LEFT JOIN eav_attribute_option_value eaov
                          ON eaov.option_id = eao.option_id
                   LEFT JOIN core_store cs
                           ON eaov.`store_id` = cs.`store_id`

            WHERE  ea.`entity_type_id` = 4
            ORDER  BY ea.attribute_id,
                      ea.backend_type,
                      ea.attribute_code;
