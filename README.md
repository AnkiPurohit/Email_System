# Email-System

----------

## Installation

### Back-end

Clone the repository

    git clone git@github.com:AnkiPurohit/Email_System.git

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes (DB CONNECTION configs) in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate
    
Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

### Front-end

Install all the dependencies using Node Package Manager

    npm install
      

### API Documentation

To send email use following API: 


    {{base_url}}/api/send-email
    

For authorization you can get API token from our laravel system.

Example of accepted payload response: 
                            
                            
                            {
                                   "receivers":[
                                      {
                                         "email":"ankitapurohit41@gmail.com",
                                            "name":"Ankita",
                                            "surname":"Purohit",
                                            "hobby":"Travelling"

                                      },
                                      {
                                         "email":"tuser378@gmail.com",
                                            "name":"Test",
                                            "surname":"User",
                                            "hobby":"Sports"

                                      }
                                   ],
                                   "template_id":"8"
                                }
                                
 
 You can send any parameter in  email payload which you have describe in template using curly brackets i.e {name}, {surname}, {hobby}.
 
 Email Template example :
 
                    <p>Hi {{name}},</p>
                    <p>Thanks for choosing us to build your profile.</p>
                    <p style="padding-left: 40px;"><strong>Name</strong>: {{name}}</p>
                    <p style="padding-left: 40px;"><strong>Surname</strong>: {{surname}}</p>
                    <p style="padding-left: 40px;"><strong>Hobby</strong>: {{hobby}}</p>
                    <p>Regards,</p>
                    <p>Team Ankita</p>

For Email Subject : you can also add dynamic varaible using curly brackets.
