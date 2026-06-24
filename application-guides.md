## **Individual Assignment: ICT600 Web Technology and Application** 

## **Assignment Title** 

## **Student Management System Using PHP and MySQL** 

## **Objective** 

Develop a web-based Student Management System using PHP and MySQL that allows users to manage student records through CRUD operations (Create, Read, Update, Delete). The Web site must provide a home page and about page. 

Learning Outcomes 

Upon completion, students should be able to: 

1. Develop dynamic web applications using PHP. 

2. Connect PHP applications to MySQL databases. 

3. Implement CRUD operations. 

4. Design and deploy a simple database-driven web application. 

Requirements 

_Functional Requirements_ 

Students must develop a PHP web application with the following features: 

## 1. **Home Page (index.php)** 

   - Display system title and navigation menu. 

   - Provide links to all system functions. 

2. **Add Student (add_student.php)** 

   - Create a form to enter: 

      - Student ID 

      - Student Name 

      - Address 1 

      - Address 2 

      - Postcode 

      - City 

      - Gender 

      - Race 

      - Religion 

      - Contact Number 

      - Email 

   - Save data into a MySQL database. 

## 3. **View Students (view_student.php)** 

- Display all student records in an HTML table. 

- Retrieve data from the database. 

## 4. **Update Student (edit_student.php)** 

- Allow users to edit existing student information. 

- Update records in the database. 

## 5. **Delete Student (delete_student.php)** 

- Allow users to remove student records. 

- Display a confirmation message before deletion. 

## 6. **Search Student (search_student.php)** 

- Search students by Student ID or Name. 

- Display matching records. 

- Add a new Action button which is “View”. Refer the example in the picture below. The “View” button is used to display all information about student as stated in STUDENT table. When the user clicks the button “View”, a new page will display all the student information. You can refer the example page below. 

## Database Requirements 

## **Database Name:** STUDENTDB 

## **Table Name:** student 

## Extension Tasks 

You must also implement the following task 

   - User Login Authentication 

   - Session Management 

   - File Upload (Student Photo) 

   - Responsive Design 

   - Add one more column to store student photo in user table 

   - Identify the category of the system user. Category of user is determined based on the access role that stored in **USER** table. When the student login into the system, the system will disable the button update, add and delete. Student is allowed to view the detail info only. Meanwhile, if the access role is admin, the system will enable all the button and it will allow the admin to update, delete and add student. 

- Add **500 records** of student into **STUDENT** table // i will do it, just insert 1 or 2

- Add **500 records** of user into **USER** table // I will do it, just insert 1 or 2

## **Assignment Report Contents:** 

## 1. Introduction 

Introduce the current static web site, strength and weakness of the Web site. Briefly explain about the system. 

## 2. System Design 

## 2.1 Site map 

- 2.2 User Interface Design 

## 3. Implementation 

- 3.1 System Function 1 (e.g. Login Page) 

- 3.2 System Function 2 (e.g. Add Student) 

- 3.3 System Function 3 (e.g. Update Student) 

- 3.4 System Function 4 (e.g. Delete Student) 

- 3.5 System Function 5 (e.g. View Student) 

* each function includes function description, screenshot, and source code 

## 4. Conclusion 

## **Rubrics and Marking Scheme (100 Marks)** 

|**Criteria**|**Marks(%)**|
|---|---|
|Database Design|15|
|Add Record Function|15|
|View Record Function|15|
|Update Record Function|15|
|Delete Record Function|15|
|Search Function|10|
|User Interface Design|5|
|Documentation & Report|10|
|**Total**|**100**|



