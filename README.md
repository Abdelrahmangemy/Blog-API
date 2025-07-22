# Blog Platform API

A RESTful API for a blog platform built with Laravel, featuring user authentication with JWT, role-based permissions, blog post CRUD operations, comments, and search/filter functionality. The project adheres to clean code and SOLID principles.

## Features
- User registration and login with JWT authentication
- Two user roles: admin (full CRUD access) and author (CRUD on own posts)
- Blog post management with title, content, category, and author
- Predefined post categories: Technology, Lifestyle, Education, Sports, Entertainment
- Paginated post listing with filters (category, author, date range, search by title/author/category)
- Comment system for authenticated users
- Secure endpoints with role-based authorization
- API documentation via Postman collection
- Caching for post listing
- Input validation for all endpoints

## Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js and npm (optional for frontend assets)
- Laravel CLI

## Installation

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd blog-api
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**
   - Copy `.env.example` to `.env`
   - Update database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=blog_api
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

4. **Configure JWT**
   - Publish JWT configuration:
     ```bash
     php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
     ```
   - Generate JWT secret:
     ```bash
     php artisan jwt:secret
     ```

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Seed Data (Optional)**
   - Manually create admin users in the database by setting `role` to 'admin'.

7. **Start the Server**
   ```bash
   php artisan serve
   ```
   Access the API at `http://localhost:8000`.

## API Usage
- Use the Postman collection (`BlogPlatformAPI.postman_collection.json`) to test endpoints.
- **Authentication**:
  - Register: `POST /api/register`
  - Login: `POST /api/login` to obtain a JWT token
  - Include the token in the `Authorization` header: `Bearer <token>`
- **Endpoints**:
  - `POST /api/posts`: Create a post
  - `GET /api/posts`: List posts with optional filters (`category`, `author`, `start_date`, `end_date`, `search`, `per_page`)
  - `GET /api/posts/{id}`: Show a post
  - `PUT /api/posts/{id}`: Update a post (author or admin only)
  - `DELETE /api/posts/{id}`: Delete a post (author or admin only)
  - `POST /api/posts/{id}/comments`: Add a comment (authenticated users)

## Postman Collection
- Import `BlogPlatformAPI.postman_collection.json` into Postman.
- Set the `base_url` variable to `http://localhost:8000`.
- Update the `token` variable with the JWT obtained from `/api/login`.
- Use the "List Posts with Filters" request to test filtering by category, author, date range, or search term.

## SOLID Principles Applied
- **Single Responsibility**: Controllers handle HTTP requests, repositories manage data access, and DTOs encapsulate filter data.
- **Open/Closed**: Repository and filter logic are extensible for new filter types.
- **Liskov Substitution**: Repository interface allows swapping implementations.
- **Interface Segregation**: Specific interfaces for post operations.
- **Dependency Inversion**: Dependencies injected via constructor.

## Clean Code Practices
- Meaningful naming (e.g., `PostFilterDTO`, `applyFilters`)
- Small, focused methods
- Input validation via `PostIndexRequest`
- Consistent structure and type hints
- Reusable caching mechanism

## Bonus Features
- **Caching**: Post list endpoint cached for 60 seconds.
- **Validation**: Robust input validation for all filter parameters.
- **Search**: Enhanced search by title, author name, and category.

## Contributing
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit changes (`git commit -m 'Add YourFeature'`)
4. Push to the branch (`git push origin feature/YourFeature`)
5. Open a pull request
