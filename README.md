## Project Setup:

### 1. Clone the repo to htdocs or www folder

```
git clone gslgit@192.168.10.63:/home/gslgit/ems2.1.git
```

### 2. go to the directory 
```
cd ems2.1
```

### 3. Install Composer
```
composer install
```

### 3.1 Composer update
```
composer update
```

### 3.2 Spatie Install
```
 composer require spatie/laravel-permission
```


### 4. Create .env File
```
copy .env.example as .env
```

### 5. Generate Key
```
php artisan key:generate
```

### 6. Enable Permission (for Linux User)

```
sudo chmod -R 777 storage
```

## 7. Database Section

```
Create db ems_v2
```

```
import ems_v2.sql stored in ems2.1 project directory 
```

# Great ! Done! 

## 8. From Browser
```html
http://localhost/ems2.1/public
```

### 10. User credentials for login
```html

body: 
    username: CEO.
    or,Email :anis.rahman@genusys.us
    password: 12345678
```


```
    Role: management
    username: PRESIDENT
    password: 12345678

    Role: hr
    username: 21
    password: 12345678

    Role: headOfDepartment
    username: 319
    password: 12345678

    Role: employee
    username: 211
    password: 12345678
```









## 11.

```
Few pages still not connected to sidebar so need to check by URL hitting  ( url find from - routes/web.php )
```


### Development Log [Unfinished]

- Pusher Notification                   **(Remaining)**
- Automail system                       **(Remaining)**
- Evaluation average points, current position check, evaluation status and access control             **(Remaining)**
- Download issue in policy, jobdescription                       **(Remaining)**
- Facilities edit/update in employee profile page                **(Remaining)**
- Integrate gmail                                                **(Remaining)**
- Profile Update history add in db & update when approve         **(Remaining)**
- Attachment send to specific department/employee, attachment file delete issue when edit attachment  **(Remaining)**
- Administrator Privilege and Permission Privilege is implemented but not used for ACL. [Can remove as not of use] 
- Git updated


