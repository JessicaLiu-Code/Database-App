- ZYZ: Get email address (1)
- SY: Postal code entry (2)
- WZC: Phone number entry (1)
- LJH: Household Info (1)
- SC: Bathroom listing (1)

Time for next meeting: 9pm ET on Saturday Nov 5th.

-------
2022-11-05

Folder structure
- lib
  - db_config.php
  - helper_func.php
  - 
- css
- js
- sql
  - schema.sql (sc, finished)
  - generate_test_data.py (wzc, sy)
    - args:
      - sample_size: int
      - random_seed: int
    - sy: Postal code, manufacturer, appliance.
    - wzc: Household, phone, bathroom.

Php part:
- ljh: get email address - household info (4)
- zyz: add bathroom - bathroom listing (4)
- sc: add appliance - appliance listing (7)
- Make sure insertions really work in db.

Naming schema: `<name_abbr>_<file name>`, all lower case.

Next meeting: next Mon (Nov 14) 8:30 pm ET.

-----

Next meeting: Nov 19 Saturday
- NJ: 15:00
- IL: 14:00
- AZ: 13:00


Individual task
- LJH: TV report.
- SY: Pre-calculate report results.
- SC: Manufacturer & model search.
- ZYZ: Bathroom stats report.
- WZC: Extra fridge report.


Common task
- Make sure everything on your page is ready except css.
- Test corner case.
- Add progress bar.
- Link to others' pages.
- After you are confident with your part, **remove your initial**, and put it into `Phase3_dev` branch.
- Make sure all reports have the following two buttons.
  - Return to main menu.
  - Return to report menu.
- Do not worry about closing DB sessions for now.

Others:

1. include <code>$_SESSION["Email"]</code> at the begining in the householdinfo

```php
if (!isset($_SESSION['email'])) {
	header('Location: login.php');
	exit();
}
```

2. Debug style

```php
<?php
    //Insert at place of potential bugs
   echo "<script>alert('some information')</script>";
?>
```

3. For each database queries and interactions:

```php
<?php
    $queryID = mysqli_query($conn, $query);
            
    include('lib/show_queries.php');

    if ($queryID  == False) {
        echo '<script>alert("$query")</script>';
        } 
?>
```

4. Get string values from post methods: mysqli_real_escape_string($conn,$str_post)

5. Javascript check onsubmit

```javascript
<form actioion = "POST" onsubmit="myFunction()">
  Enter name: <input type="text">
  <input type="submit">
</form>

<script>
    myFunction{
        alert("");
        return false   
    }
</script>
```

-----

Meeting: 2022-11-20 20:30 ET


Common tasks:
- Full functionality, including
  - Link to other pages.
  - css
  - Header "Connected to DB."
  - "Hem", not "Ham".
  - Progress bar.
  - Two buttons on report page: "Main Menu" and "Report Menu". Put them at the top of the page (refer to Yuan's report on this).
  - Table: Everything aligned to middle, including column names.
  - For reports, test empty DB case.
  - Whenever `$_SESSION["Email"]` is not set, return to get email page. This point does not apply to the report pages.


Individual tasks
- WZC:
  - Make drill-down format same as Jiahui.
- SY:
  - Change font.
  - Generate SQL for demo data.
- SC:
  - Manufacturer search - deal with the white space case.
    - Note: Replace & replace back white space (possible).
- ZYZ:
  - Put back bathroom constraints.
  - Fix is_primary insertion.
  - Finish bathroom stats report.
- LJH:
  - Value -> placeholder.
  - Progress bar values.


  ZYZ test

  - Enter household info:
    - Square footage must not be empty;
    - HType house VS. House.
  - Enter phone number:
    - not found in DB.

  - Add Bathroom:
    - need a skip button
    - Disable checkbox functionality

  - Add Appliance:
    - need a skip button
    - cooker with both cooktop and over will appear twice on the list

-----

Individual debug to-do list
- SC
  - Take "Go to list" button into consideration.
- ZYZ:
  - Change button name. done
  - Id increment (?) done
  - Primary checkbox disabling. done
  - Make columns in the middle. done
  - Bathroom report aligned to left. done
  - Make all tables in css format. done
- SY
  - White space after ":" in db config.
  - Laundry report last row.
  - Put "Connect db" to the upper left corner.
  - Double check all ad-hoc changes and push if necessary.
- LJH
  - No phone number will lead to DB insertion failure.
  - Display db connection. (Duplicated definition of `$conn`)
  - Make all columns in the middle.
- WZC
  - Remove all progress bars.
  - Make table rows in the middle.

- ZYZ test 11/21:
  - bathroom list page & appliance list page:
    - position of '+ add another' and button inconsistent
  - appliance list page:
    - progress bar should be 75%
  - addBath page & addApp page:
    - button name in consistent
  - view report page:
    button name inconsitent with each report
  - bath stats report page:
    - corner case concern: intrigued when 0 bathroom, lead to 0 registration, not lead to 0 email/phone/household/bathroom, only lead to 0 appliance
    - what should be the condition, maybe need to go to piazza for confirmation
    - does this apply to every report corner cases
