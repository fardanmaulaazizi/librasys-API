# <p align="center">LibraSys</p>

<p align="center" >
    <img width="200" src="app_screenshots\librasys.png" alt="LibraSys Logo">
</p>

## <p align="center">"API for Library Management System"</p>
This is a library management system built with Laravel, designed to manage users, books, and borrowings, with three distinct user roles: Head of Library, Librarian, and Member. The system uses Laravel Sanctum to secure API authentication, providing safe and efficient token-based authentication for every API request.
## Tech Stack

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Sanctum](https://img.shields.io/badge/sanctum-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)

## Table of contents
   * [System Overview](#system-overview)
   * [Installation](#installation)
   * [Api Reference](#api-reference)
      * [Authentication](#authentication)
          * [Login](#login)
      * [User](#user)
          * [Get All User](#get-all-user)
          * [Register a User](#register-a-user)
          * [Update a User](#update-a-user)
          * [Delete a User](#delete-a-user)
      * [Book](#book)
          * [Get All Books](#get-all-books)
          * [Add New Book](#add-new-book)
          * [Update a Book](#update-a-book)
          * [Delete a book](#delete-a-book)
      * [Borrowing](#borrowing)
          * [Get All Borrowings](#get-all-borrowings)
          * [Borrow a Book](#borrow-a-book)
          * [Return a Book](#return-a-book)
          * [Update a Borrowing](#update-a-borrowing)
          * [Delete a Borrowing](#delete-a-borrowing)
          * [Get User's Personal Borrowing](#get-users-personal-borrowing)

## System Overview
### Key Features
The application provides a robust management system with three distinct user roles, each having tailored access and capabilities:
1. Head of Library
    * **Full Control**: Can manage all aspects of the system, including user, book, and borrowing data.
    * **User Management**: Add, update, or delete users (including librarians and members).
    * **Book Management**: Oversee the addition, updating, and removal of book records.
    * **Borrowing Management**: Track and manage all book borrowings.
    * **Personal Borrowing History**: View borrowing records for personal use.
2. Librarian
    * **Comprehensive Management**: Can manage most system data, except for head of library user data.
    * **User Management**: Add, update, or delete members (but not the head of library).
    * **Book Management**: Handle book inventory, including adding and updating books.
    * **Borrowing Management**: Oversee borrowing transactions, including borrowing and returning books.
    * **Personal Borrowing History**: Access own borrowing records.
3. Member
    * **Book Browsing**: View and explore the entire collection of available books.
    * **Borrowing History**: Access personal borrowing records to track borrowed books.
  
Secure authentication using tokens to ensure data access is protected.

### Database Table Design
<p align="center" >
    <img width="300" src="app_screenshots\librasys_database.png" alt="LibraSys Database Table Design">
</p>

## Installation

### Prerequisites
Ensure you have the following installed on your machine:
- PHP 8.2
- Composer

### Steps
1. **Clone the Repository**
    ```bash
    git clone https://github.com/fardanmaulaazizi/librasys-API
    cd librasys-API
    ```

2. **Install Dependencies**
    ```bash
    composer install
    ```

3. **Environment Setup**
    Create a `.env` file by copying `.env.example`:
    ```bash
    cp .env.example .env
    ```
    Update your database credentials and other configurations in `.env`:
    ```bash
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

4. **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5. **Run Migrations with seeder**
    Create the necessary database tables by running migrations:
    ```bash
    php artisan migrate --seed
    ```

6. **Serve the Application**
    Start the Laravel development server:
    ```bash
    php artisan serve
    ```
    The application will be accessible at `http://localhost:8000`.

## API Reference

### Authentication
#### Login

```http
  GET /api/login
```
Request Body
| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | **Required**. Your Email |
| `password` | `string` | **Required**. Your Password |

### User
#### Get All User

```http
  POST /api/users?page={page}
```
Authorization:<br>
* Type: Bearer Token<br>
* Required: Yes<br>

Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `page` (optional): Specify the page number for paginated responses.

#### Register a user

```http
  POST /api/register
```
Authorization:<br>
* Type: Bearer Token
* Required: Yes

Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required** User Name |
| `email` | `string` | **Required** User Email |
| `password` | `string` | **Required** User Password |
| `role_id` | `string` | **Required** User role. **"1"** for **"Head of Library"**,**"2"** for **"Librarian"**, **"3"** for **"Member"**|

#### Update a User

```http
  PUT /api/users/{user_id}
```
Authorization:<br>
* Type: Bearer Token<br>
* Required: Yes<br>

Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `user_id` (required): The ID of the user to be changed.

Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | **Required**. User Name |
| `email` | `string` | **Required**. User Email |
| `password` | `string` |  **Required**. User Password |
| `role_id` | `string` |  **Required**. User role. **"1"** for **"Head of Library"**,**"2"** for **"Librarian"**, **"3"** for **"Member"**|

#### Delete a User

```http
  DELETE /api/users/{user_id}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:<br>
* `user_id` (required): The ID of the user to be deleted.

### Book
#### Get All Books
```http
  GET /api/books?page={page}
```
Parameters:

* `page` (optional): Specify the page number for paginated responses.

#### Add New Book
```http
  POST /api/books
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `title` | `string` | **Required**. Book Title|
| `author` | `string` | **Required**. Book Author|
| `description` | `string` | **Required**. Book Description|
| `quantity` | `int` | **Required**. Book Quantity|

#### Update a Book
```http
  PUT /api/books/22/{book_id}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `book_id` (required): The ID of the book to be changed.

Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `title` | `string` | **Required**. Book Title|
| `author` | `string` | **Required**. Book Author|
| `description` | `string` | **Required**. Book Description|
| `quantity` | `int` | **Required**. Book Quantity|

#### Delete a Book
```http
  PUT /api/books/22/{book_id}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `book_id` (required): The ID of the book to be deleted.

### Borrowing
#### Get All Borrowings
```http
  GET /api/borrowings?page={page}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `page` (optional): Specify the page number for paginated responses.

#### Borrow a book
```http
  GET /api/borrowings
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `integer` | **Required**. The ID of the user who borrowed the book|
| `book_id` | `integer` | **Required**.  The ID of the borrowed book|
| `quantity` | `int` | **Required**. Book Quantity|
| `loan_date` | `int` | **Required**. The date the book was borrowed|

#### Return a Book
```http
  PUT /api/borrowings/{borrowing_id}/return
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `borrowing_id` (required): The ID of the borrowing to be returned.
  
Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `integer` | **Required**. The ID of the user who borrowed the book|
| `book_id` | `integer` | **Required**. The ID of the borrowed book|
| `quantity` | `int` | **Required**. Book Quantity|
| `loan_date` | `int` | **Required**. The date the book was borrowed|

#### Update a Borrowing
```http
  PUT /api/borrowings/{borrowing_id}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `borrowing_id` (required): The ID of the borrowing to be updated.

Request Body:

| Field | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `integer` | **Required**. The ID of the user who borrowed the book|
| `book_id` | `integer` | **Required**. The ID of the borrowed book|
| `quantity` | `int` | **Required**. Book Quantity|
| `status` | `string` | **Required**. Borrowing status **loaned** or **returned**|
| `loan_date` | `int` | **Required**. The date the book was borrowed|
| `return_date` | `int` | **Optional**. The date the book was returned|

#### Delete a Borrowing
```http
  DELETE /api/borrowings/{borrowing_id}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `borrowing_id` (required): The ID of the borrowing to be deleted.

#### Get User's Personal Borrowing
```http
  GET /api/borrowings/user/{user_id}
```
Headers:

| Header | Value     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `Bearer {token}` | **Required**. Authentication token |
| `Content-Type` | `application/json` | Specifies the format of the request body |

Parameters:

* `user_id` (required): The ID of the user whose borrowing data will be retrieved.