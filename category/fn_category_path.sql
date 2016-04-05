#
# All credits goes to https://blog.kyp.fr/magento-tips-display-a-magento-category-path-in-sql
#

DROP FUNCTION IF EXISTS MS_CHAR_COUNT;
DROP FUNCTION IF EXISTS MS_SPLIT_STR;
DROP FUNCTION IF EXISTS MS_GET_CATEGORY_PATH;

#
# Useful to check the number of occurences of a string in another string.
#
# @param search_string  The string we want to compare
# @param search         The string we want to look for
#
# SELECT MS_CHAR_COUNT('bobo', 'b') -> 2
#
CREATE FUNCTION MS_CHAR_COUNT(search_string VARCHAR(255), search VARCHAR(255))
  RETURNS INT
DETERMINISTIC
  BEGIN
    RETURN LENGTH(search_string) - LENGTH(REPLACE(search_string, search, ""));
  END;

#
# SPLIT
#
# @param x      The string we want to split
# @param delim  The position of the element
#
# SELECT MS_SPLIT_STR('1/2/10/13', '/', 1) -> 1
# SELECT MS_SPLIT_STR('1/2/10/13', '/', 4) -> 13
#
CREATE FUNCTION MS_SPLIT_STR(x VARCHAR(255), delim VARCHAR(12), pos INT)
  RETURNS VARCHAR(255)
DETERMINISTIC
  RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
                           LENGTH(SUBSTRING_INDEX(x, delim, pos - 1)) + 1),
                 delim, '');


#
# Get the full category path
#
CREATE FUNCTION MS_GET_CATEGORY_PATH(catId INT, storeId INT, counter INT, lower_case BOOL)
  RETURNS TEXT
DETERMINISTIC
  BEGIN
    DECLARE pathFound TEXT DEFAULT '';
    DECLARE categoryPath TEXT DEFAULT '';
    DECLARE pathOcurrences INT UNSIGNED DEFAULT 0;
    DECLARE pathPart VARCHAR(255);
    DECLARE currentEntityId INT UNSIGNED DEFAULT 0;

    SELECT path
    FROM catalog_category_entity
    WHERE entity_id = catId
    INTO @categoryPath;
    SELECT attribute_id
    FROM eav_attribute
    WHERE attribute_code = 'name' AND entity_type_id = 3
    INTO @attributeId;
    SELECT MS_CHAR_COUNT(@categoryPath, '/')
    INTO @pathOcurrences;
    WHILE counter <= @pathOcurrences DO
      SET counter = counter + 1;
      SELECT SPLIT_STR(@categoryPath, '/', counter)
      INTO @currentEntityId;
      SELECT IF(t_s.value IS NULL, t_d.value, t_s.value)
      FROM catalog_category_entity_varchar AS t_d
        LEFT JOIN catalog_category_entity_varchar AS t_s
          ON (t_s.attribute_id = @attributeId AND t_s.store_id = storeId AND t_s.entity_id = @currentEntityId)
      WHERE t_d.attribute_id = @attributeId AND t_d.store_id = 0 AND t_d.entity_id = @currentEntityId
      INTO @pathPart;
      SET pathFound = CONCAT(pathFound, @pathPart, '/');
    END WHILE;
    IF (TRUE = lower_case) THEN SET pathFound = lower(pathFound); END IF;
      RETURN pathFound;
  END;

SELECT MS_GET_CATEGORY_PATH(30, 2, 2, TRUE)
