# Return the sort order for one specific attribute
SELECT
* 
FROM eav_attribute_option eao
WHERE eao.attribute_id = 18
ORDER BY sort_order ASC;

# Update the sort order based on an external table
UPDATE eav_attribute_option eao
INNER JOIN eav_attribute_option_value eaov ON eao.option_id = eaov.option_id
INNER JOIN external_database.order_table ot  ON eaov.option_id = ot.key # use any key for join
SET eao.sort_order = (10 * ge.order_num) # give the order more puffer
WHERE attribute_id = (SELECT attribute_id FROM eav_attribute WHERE attribute_code = 'your attribute code');