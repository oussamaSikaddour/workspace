<?php
return [
    "common"=>[
        "excel-file-type-err"=>"The file must be in Excel format (XLSX, XLS, CSV)",
        "actions"=>"Actions",
        "perPage"=>"Per Page"
    ],
    'users'=> [
    'info'=>"Users list",
     "fullName"=>"Name",
     "email"=>"Email",
     "specialty"=>"Specialty",
     "registration-date"=>"Registration Date",
     "phone"=>"Phone Number",
     'card_number'=>"National identification number",
     'birth_date'=>"Birth Date",
     'birth_place'=>"Birth Place",
     'address'=>"Address",
     "experience"=>"Experience",
     "field"=>"Field",
      "specialty"=>"Specialty",
      "grade"=>"Grade",
     "filters"=>[
              "specialty"=>"Specialty :",
              "user-type"=>"User Role :"
     ],
     "not-found"=>"No users Found at the moment",
    ],
    'classrooms'=>[
        "info"=>"Classrooms list",
        "createdAt"=>"added date",
        "not-found"=>"No classrooms Found at the moment",
        "name"=>"Name",
        "status"=>"Status",
        "active-limit-err"=>"Only 4 Classrooms can be activate to be shown ,in The Landing page",
    ],
    'days-off'=>[
        "info"=>"days-off list",
        "not-found"=>"No Days-off Found at the moment",
    ],
    'products'=>[
         "info"=>"Products List",
        "createdAt"=>"added date",
        "not-found"=>"No Products Found at the moment",
        'name' => 'Name',
         "status"=>"Status",
         "active-limit-err"=>"Only 4 Products can be activate to be shown ,in The Landing page",

    ],
    'ourQualities'=>[
        'info'=>"Qualities List",
        "createdAt"=>"added date",
        "not-found"=>"No Qualities Found at the moment",
        'name' => 'Name',
         "status"=>"Status",
         "active-limit-err"=>"Only 4 Qualities can be activate to be shown ,in The Landing page",

    ],
    'trainings'=>[
        "info"=>"Trainings list",
        "createdAt"=>"added date",
        "not-found"=>"No Trainings Found at the moment",
        'name' => 'Name',
         "status"=>"Status",
         "active-limit-err"=>"Only 4 Trainings can be activate to be shown ,in The Landing page",

    ],
    "reservations"=>[
        "info"=>"Reservations List",
        "totalPrice"=>"Total Price",
        "state"=>"State",
        "client"=>"Client",
        "classroom"=>"Classroom",
        "dateStart"=>"Date Start",
        "dateEnd"=>"Date End",

        "not-found"=>"No reservations Found at the moment",
    ],
   "messages"=>[
    "info"=>"Messages List",
    "createdAt"=>"Added At",
    "not-found"=>"No messages Found at the moment"
   ]

];
