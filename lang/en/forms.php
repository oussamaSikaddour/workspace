<?php
   return [
       "common"=>[
         "submit-btn"=>"Validate",
         'tel-match-err'=>"The :attribute must commence with either 05, 06, or 07, followed by a precise sequence of 8 digits.",
         'fix-match-error'=>"The :attribute must commence 0, followed by a precise sequence of 8 digits.",
         'img-error'=>"The File must of the type image",
         'user-id-error'=>"The :attribute is required",
       ],
      "login"=>[
             "instruction"=>"Please provide the following information",
            'email'=>"Email",
            'password'=>"Password",
            "forget-password-link"=>"Forgot your password ?",
            "register-link"=>"Create an account",
            "no-user-err"=>"No matching users found with provided email and password",
            "too-many-attempts"=>"You have made too many attempts. Please try again in a few minutes."
          ],
     "register"=>[
        "first-f"=>[
            "instruction"=>"Your email must be valid, a verification code will be sent to you",
            "login-link"=>"I already have an account",
            "l-name"=>"Last Name",
            "f-name"=>"First Name",
            "b-date"=>"Birth Date",
            'email'=>"Email",
            'tel'=>"Phone Number",
            'password'=>"Password",
            "success-txt"=>"A verification code has been sent to your email address"
        ],
        "second-f"=>[
            "instruction"=>"Your email must be valid, a verification code will be sent to you",
            "new-code-btn"=>"Get a new verification code",
            'email'=>"Email",
            "code"=>"Verification code",
            'code-err'=>"Verification code is invalid"

        ]
        ],

        "forget-pwd"=>[
            "first-f"=>[
                "instruction"=>"Your email must be valid, a verification code will be sent to you",
                "email"=>"Email",
                "success-txt"=>"A verification code has been sent to your email address"
            ],
            "second-f"=>[
                "instruction"=>"Enter the verification code sent to you",
                'email'=>"Email",
                "code"=>"Verification code",
                "password"=>"The New Password",
                "no-user"=>"No matching users found with provided email",
                "code-err"=>"Verification code is invalid"
            ]
            ],

        "change-email"=>[
                "instruction"=>"Your new email must be a valid One",
                'old-email'=>"Old Email",
                "new-email"=>"New Email",
                "pwd"=>"Password",
                "no-user"=>"Check your old email or password",
                "success-txt"=>"your Email has been changed,You will now be logged out"

            ],
         "change-pwd"=>[
            "instruction"=>"Please provide the following information:",
           "pwd"=>"The Old Password",
           "new-pwd"=>"The New Password",
           "pwd-err"=>"check your old password",
           "success-txt"=>"your password has been changed. You will now be logged out"
         ],

        "site-params"=>[
            "first-f"=>[
                "instruction"=>"Please provide the following information:",
                "email"=>"Email",
                "password"=>"Password",
                "no-user"=>"No matching users found with provided email and password",
                "no-access"=>"You do not have the rights to access the next step",
                "success-txt"=>"Be careful when changing the global state of the platform"
            ],
            "second-f"=>[
                "instruction"=>"manage the maintenance state of the platform:",
                 "disable"=>"Disable",
                 "enable"=>"Enable",
                 "db-download-btn"=>"Download the database",
                 "no-db"=>"No database backups available.",
                 "state"=>"the maintenance state of the platform",
                 "success-txt"=>"You have successfully changed the maintenance state"
            ]

            ],

        "user"=>[
            'tel-match-err'=>"The phone number must commence with either 05, 06, or 07, followed by a precise sequence of 8 digits.",
            "add"=>[
             "success-txt"=>"User was created successfully",
            ],
            "update"=>[
             "success-txt"=>"User was successfully updated"
            ]
            ],
        "classroom"=>[
            "img-err"=>"Image must be in image format",
            "add"=>[
             "success-txt"=>"Classroom was created successfully",
            ],
            "update"=>[
             "success-txt"=>"Classroom was successfully updated"
            ]
            ],
        "product"=>[
            "img-err"=>"Image must be in image format",
            "add"=>[
             "success-txt"=>"The Product was created successfully",
            ],
            "update"=>[
             "success-txt"=>"The Product was successfully updated"
            ]
            ],
        "training"=>[
            "add"=>[
             "success-txt"=>"The Training was created successfully",
            ],
            "update"=>[
             "success-txt"=>"The Training was successfully updated"
            ]
            ],


        "landing"=>[
            "landline"=>"Landline number",
            "phone"=>"Phone Number",
            "fax"=>"Fax",
            "map"=>"google Map",
            "email"=>"Email",
            "logo"=>"Change Logo",
            "update"=>[
                "success-txt"=>"The Landing Page was successfully updated"
               ]
        ],
        "hero"=>[
            "title-fr"=>"Title in French",
            "title-ar"=>"Title in arabic",
            "sub-title-fr"=>"Subtitle in French",
            "sub-title-fr"=>"Subtitle in arabic",
            "image"=>"Update Images",
            "update"=>[
                "success-txt"=>"The Welcome was successfully updated"
               ]
            ],
        "aboutUs"=>[
            "titleFr"=>"Title in French",
            "titleAr"=>"Title in arabic",
            "descriptionAr"=>"Description in arabic",
            "descriptionFr"=>"Description in french",
            "image"=>"Change image",
            "update"=>[
                "success-txt"=>"The AboutUs page was successfully updated"
               ]
            ],
        "ourQuality"=>[
            "nameFr"=>"Name in French",
            "nameAr"=>"Name in arabic",
            "image"=>"Change image",
            "add"=>[
                "success-txt"=>"The Quality was successfully added"
            ],
            "update"=>[
                "success-txt"=>"The Quality was successfully updated"
               ]
            ],
    "socials"=>[
        "youtube"=>"Youtube",
        "facebook"=>"Youtube",
         "github"=>"Github",
         "tiktok"=>"TikTok",
         "instagram"=>"Instagram",
         "linkedin"=>"Linkedin",
         "update"=>[
            "success-txt"=>"Your socials were successfully updated"
           ]
         ],
    "reservation"=>[
    "add"=>[
        "success-txt"=>"You have successfully booked this classroom"
    ]
    ],
    "message"=>[
        "name"=>"Name",
        "message"=>"Message",
        "email"=>"email",
    "add"=>[
        "success-txt"=>"Your message has been sent successfully "
    ]
    ]
   ]
     ;
