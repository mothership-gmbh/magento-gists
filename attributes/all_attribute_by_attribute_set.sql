SELECT ea.attribute_code,
       ea.attribute_id,
       ea.backend_model,
       ea.frontend_input,
       ea.is_user_defined,
       ea.is_required,
       ea.default_value
FROM   eav_attribute_set eas
       LEFT JOIN eav_entity_attribute eea
              ON eas.`attribute_set_id` = eea.`attribute_set_id`
       LEFT JOIN eav_attribute ea
              ON eea.`attribute_id` = ea.attribute_id
WHERE  eas.`attribute_set_id` = 4
   AND eas.`entity_type_id` = 4;
