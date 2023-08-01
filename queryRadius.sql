WITH
  HOUSESELECT (Email,No_occupants,No_bedroom)
  AS
  (SELECT Email,No_occupants,No_bedroom
   FROM HOUSEHOLD,
        (SELECT Postal_code,
                POWER(SIN(RADIANS(Lat2-Lat1)/2),2)+COS(RADIANS(Lat1))*COS(RADIANS(Lat2))*POWER(SIN(RADIANS(Lon2-Lon1)/2),2) AS Geo_A
         FROM (SELECT S.Postal_code AS Postal_code,
                      S.Latitude AS Lat2,
                      S.Longitude AS Lon2,
                      T.Latitude AS Lat1,
                      T.Longitude AS Lon1
               FROM ZIPCODE AS S,ZIPCODE AS T
               WHERE T.Postal_code='$Zip'
              ) AS ZIPJOIN
        ) AS ZIP_RECALC
   WHERE HOUSEHOLD.Postal_code=ZIP_RECALC.Postal_code AND FLOOR(3958.75*2*ATAN2(SQRT(Geo_A),SQRT(1-Geo_A))) <= $Radius
  )
  SELECT '$Zip' AS Postal_code,
         $Radius AS Search_radius,
         AvgBathCounts,
         AvgBedroom,
         AvgOccupants,
         AvgCommodesRatio,
         AvgAppCounts,
         Heat_source AS MostCommonHeatSource
  FROM
    (
        SELECT ROUND(AVG(count_bath),1) AS AvgBathCounts
        FROM (
            SELECT BATHROOM.Email,
                   COUNT(BATHROOM.Email) AS count_bath
            FROM BATHROOM,HOUSESELECT
            WHERE BATHROOM.Email=HOUSESELECT.Email
            GROUP BY BATHROOM.Email
        ) AS BATHCOUNT
    ) AS AVGBATH
    CROSS JOIN
    (
        SELECT ROUND(AVG(No_bedroom),1) AS AvgBedroom
        FROM HOUSESELECT
    ) AS AVGBED
    CROSS JOIN
    (
        SELECT ROUND(AVG(No_occupants),0) AS AvgOccupants
        FROM HOUSESELECT
    ) AS AVGOCC
    CROSS JOIN
    (
        SELECT CONCAT('1:',ROUND(SUM(count_commode)/SUM(No_occupants),2)) AS AvgCommodesRatio
        FROM (
            SELECT HOUSESELECT.Email,
                   HOUSESELECT.No_occupants,
                   SUM(BATHROOM.No_commode) AS count_commode
            FROM BATHROOM,HOUSESELECT
            WHERE BATHROOM.Email=HOUSESELECT.Email
            GROUP BY HOUSESELECT.Email,HOUSESELECT.No_occupants
        ) AS COMCOUNT
    ) AS AVGCOMMODE
    CROSS JOIN
    (
        SELECT ROUND(AVG(count_app),1) AS AvgAppCounts
        FROM (
            SELECT APPLIANCE.Email,
                   COUNT(APPLIANCE.Email) AS count_app
            FROM APPLIANCE,HOUSESELECT
            WHERE APPLIANCE.Email=HOUSESELECT.Email
            GROUP BY APPLIANCE.Email
        ) AS APPCOUNT
    ) AS AVGAPP
    CROSS JOIN
    (
        SELECT Heat_source,SUM(Ncount) AS Ncount
        FROM (
                SELECT Heat_source,COUNT(*) AS Ncount
                FROM DRYER,HOUSESELECT
                WHERE DRYER.Email=HOUSESELECT.Email
                GROUP BY Heat_source
                UNION ALL
                SELECT Heat_source,COUNT(*) AS Ncount
                FROM COOKTOP,HOUSESELECT
                WHERE COOKTOP.Email=HOUSESELECT.Email
                GROUP BY Heat_source
                UNION ALL
                SELECT Heat_source,COUNT(*) AS Ncount
                FROM OVEN_Heat_source,HOUSESELECT
                WHERE OVEN_Heat_source.Email=HOUSESELECT.Email
                GROUP BY Heat_source
                ) AS HEATUNION
        GROUP BY Heat_source
        ORDER BY Ncount DESC
        LIMIT 1
    ) AS TOPHEATSOURCE;
