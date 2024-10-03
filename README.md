
# LibraSys

API for Library Management.


## Features

Consists of 3 Types of User Roles
#### Head of Library
- Manage user data.
- Manage books data.
- Manage book borrowings data.
- View personal borrowings
#### Librarian
- Manage user data (except data for the head of library).
- Manage book data.
- Manage book borrowings.
- View personal borrowings
#### Member
- View all books.
- View personal borrowings





## API Reference

### Authentication
#### Login

```http
  GET /api/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email` | `string` | Your Email |
| `password` | `string` | Your Password |

### User
#### Get all user

```http
  POST /api/users?page={page}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>*.* Token obtained from login route response |

| Query | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `page` | `int` | **Optional**. default value is 1 |

#### Register a user

```http
  POST /api/register
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>*.* Token obtained from login route response |


| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | User Name |
| `email` | `string` | User Email |
| `password` | `string` | User Password |
| `role_id` | `string` | User role. **"1"** for **"Head of Library"**,**"2"** for **"Librarian"**, **"3"** for **"Member"**|

#### Update a user

```http
  PUT /api/users/{user_id}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `string` | The ID of the user to be changed |

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string` | User Name |
| `email` | `string` | User Email |
| `password` | `string` |  User Password |
| `role_id` | `string` |  User role. **"1"** for **"Head of Library"**,**"2"** for **"Librarian"**, **"3"** for **"Member"**|

#### Delete a user

```http
  DELETE /api/users/{user_id}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `int` | The ID of the user to be deleted |

### Book
#### Get all books
```http
  GET /api/books
```
| Query | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `page` | `int` | **Optional**. default value is 1 |

#### Add new book
```http
  POST /api/books
```

| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `title` | `string` | Book Title|
| `author` | `string` | Book Author|
| `description` | `string` | Book Description|
| `quantity` | `int` | Book Quantity|

#### Update a book
```http
  PUT /api/books/22/{book_id}
```

| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `book_id` | `int` | The ID of the book to be updated |

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `title` | `string` | Book Title|
| `author` | `string` | Book Author|
| `description` | `string` | Book Description|
| `quantity` | `int` | Book Quantity|

#### Delete a book
```http
  PUT /api/books/22/{book_id}
```

| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `book_id` | `int` | The ID of the book to be deleted |

### Borrowing
#### Get all borrowings
```http
  GET /api/borrowings?page={page}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| Query | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `page` | `int` | **Optional**. default value is 1 |

#### Borrow a book
```http
  GET /api/borrowings
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `integer` | The ID of the user who borrowed the book|
| `book_id` | `integer` | The ID of the borrowed book|
| `quantity` | `int` | Book Quantity|
| `loan_date` | `int` | The date the book was borrowed|

### Return a book
```http
  PUT /api/borrowings/{borrowing_id}/return
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `borrowing_id` | `int` |The ID of the borrowing to be returned |

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `integer` | The ID of the user who borrowed the book|
| `book_id` | `integer` | The ID of the borrowed book|
| `quantity` | `int` | Book Quantity|
| `loan_date` | `int` | The date the book was borrowed|

### Update a borrowing
```http
  PUT /api/borrowings/{borrowing_id}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `borrowing_id` | `int` |The ID of the borrowing to be returned |

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `integer` | The ID of the user who borrowed the book|
| `book_id` | `integer` | The ID of the borrowed book|
| `quantity` | `int` | Book Quantity|
| `status` | `string` | Borrowing status **loaned** or **returned**|
| `loan_date` | `int` | The date the book was borrowed|
| `return_date` | `int` | **Optional**. The date the book was returned|

### Delete a borrowing
```http
  DELETE /api/borrowings/{borrowing_id}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `borrowing_id` | `int` |The ID of the borrowing to be deleted |

### Get user personal borrowing
```http
  GET /api/borrowings/user/{user_id}
```
| Header | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `Authorization` | `string` | **Bearer Token <token>**. Token obtained from login route response |

| URL parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `user_id` | `int` |The ID of the user whose borrowing data will be retrieved |

## Installation


1.  Clone the repository to your local machine using the following commandt:

    ```bash
    git clone https://github.com/fardanmaulaazizi/librasys-API
    cd librasys-API
    ```

2.  Adjust the application configuration in the `.env` file (especially the database settings). You can obtain the `.env` file by duplicating the `.env.example` file and renaming it to `.env`.

3.  Generate the `APP_KEY` for the application using the command:

    ```bash
    php artisan key:generate
    ```

4.  Install the necessary dependencies for the application using the command:

    ```bash
    composer install
    ```

5.  Migrate the database along with its seeders using the command:

    ```bash
    php artisan migrate:fresh --seed
    ```

6.  Run the program<br> 
((Optional) using composer)

    ```bash
    php artisan serve
    ```