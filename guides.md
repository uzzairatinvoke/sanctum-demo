// models

- User (users)
    - email (string)
    - name (string)
    - password (hashed string)
    - created_at, updated_at
- Document
    - title (string)
    - content (text)
    - user_id (foreign key)
- Role
    - Available Roles
        - Admin (admin)
        - Manager (manager)
        - Employee (employee)
- Permission
    - Available Permissions
        - create-documents
        - view-documents
        - edit-documents
        - delete-documents


1. create Document model and migration
2. populate Roles and permissions in the system
3. create Users, create DocumentFactory, create documents for each users, 
assign permission to the roles
assign roles and permission to the users
4. create Document Controller and necessary routes

