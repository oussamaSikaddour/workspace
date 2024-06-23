<?php

return [
  "common"=>[
    "submit-btn"=>"Save",
    "img-type-err"=>":attribute must be in image format",
    "pdf-type-err"=>":attribute  must be pdf file"
  ],
 "user"=>[
    'email'=>"Email",
    "l-name"=>"Last Name",
    "f-name"=>"First Name",
    "profile-img"=>"Profile picture",
    "cv"=>"CV",
    "card-number"=>"National Card Number",
    "b-date"=>"Birth Date",
    'b-place'=>"Birth Place",
     "address"=>"Address",
    'tel'=>"Phone Number",
    "work-title"=>"Work Title",
     "field"=>"Work Field",
    "specialty"=>"Specialty",
     "experience"=>"Experience",
      "grade"=>"Grade",
    "h3"=>"The email must be valid, a verification code will be sent to it",
    "for"=>[
        "add"=>"Add User",
         "update"=>"Update User"
    ],

 ],
 "role"=>[
  "for"=>[
    "manage"=>"Manage Roles"
  ]
  ],

"classroom"=>[
    "nameFr"=>"Name in French",
    "nameAr"=>"Name in arabic",
    "descriptionFr"=>"Description in French",
    "descriptionAr"=>"Description in Arabic",
    "longitude"=>"Longitude",
    "latitude"=>"Latitude",
    "status"=>"Status",
    "pricePerHour"=>"Price per hour",
    "pricePerDay"=>"Price per day",
    "pricePerWeek"=>"Price per week",
    "pricePerMonth"=>"Price per month",
    "openTime"=>"Open Time",
    "closeTime"=>"Close Time",
    "capacity"=>"Capacity",
    'workingDays'=>"Working Days",
    'image'=>"Images",

    "for" => [
        "add" => "Add Classroom",
        "update"=>"Update Classroom"
    ]
],

"days-off"=>[
    "days-off-start"=>"Starting Date",
    "days-off-end"=>"Ending Date",
    "for" => [
        "add" => "Add days-off",
        "update"=>"Update days-off"
    ]
],
"product"=>[
    "nameFr"=>"Name in French",
    "nameAr"=>"Name in arabic",
    "descriptionFr"=>"Description in French",
    "descriptionAr"=>"Description in Arabic",
     "price"=>"Price",
     "quantity"=>"Quantity",
    'image'=>"Product Images",

    "for" => [
        "add" => "Add Product",
        "update"=>"Update Product"
    ]
],
"ourQuality"=>[
    "nameFr"=>"Name in French",
    "nameAr"=>"Name in arabic",
    'image'=>"Add Image",
    "for" => [
        "add" => "Add Quality",
        "update"=>"Update Quality"
    ]
],
"training"=>[
    "nameFr"=>"Name in French",
    "nameAr"=>"Name in arabic",
    "descriptionFr"=>"Description in French",
    "descriptionAr"=>"Description in Arabic",
    "status"=>"Status",
    "start_at"=>"Start At",
    "end_at"=>"End At",
    "capacity"=>"Capacity",
    'priceTotal'=>"Total Price",
    'pricePerSession'=>"Price Per Session",
    'image'=>"Image",
     'formatter'=>"Formatter",

    "for" => [
        "add" => "Add Training",
        "update"=>"Update Training"
    ]
],
"reservation"=>[
 "startDate"=>"Start Date",
 "endDate"=>"End Date",
 "capacity"=>"Capacity",
 "startTime"=>"Start Time",
 "endTime"=>"End Time",
 "days"=>"Days",
 "hourly"=>"Book by Hour",
 "for" => [
    "add" => "Book this ClassRoom",
]
 ],

"reply"=>[
    "success"=>"Your reply has been sent successfully",
    "for" => [
        "reply" => "Send a reply",
    ]
]
];
