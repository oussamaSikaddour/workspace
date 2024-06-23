<?php
return [
    "common"=>[
        "submit-btn"=>"Valider",
        'tel-match-err' => "Le :attribute doit commencer par 05, 06 ou 07, suivi d'une séquence précise de 8 chiffres.",
        'fix-match-error' => "Le :attribute doit commencer par 0, suivi d'une séquence précise de 8 chiffres.",
        'img-error' => 'Le fichier doit être de type image',
        'user-id-error' => "Le champ :attribute est requis",
    ],
    "login"=>[
        "instruction"=>"Veuillez fournir les informations suivantes :",
        'email'=>"Email",
        'password'=>"Mot de passe",
        "forget-password-link"=>"Mot de passe oublié ?",
        "register-link"=>"Créer un compte",
        "no-user-err"=>"Aucun utilisateur correspondant trouvé avec l'email et le mot de passe fournis",
        "too-many-attempts"=>"Votre tentative de connexion est temporairement bloquée en raison de tentatives répétées infructueuses. Veuillez réessayer dans quelques minutes."
    ],

    "register"=>[
        "first-f"=>[
            "instruction"=>"Votre email doit être validé, un code de vérification vous sera envoyé",
            "login-link"=>"J'ai déjà un compte",
            "l-name"=>"Nom de famille",
            "f-name"=>"Prénom",
            "b-date"=>"Date de naissance",
            'email'=>"Email",
            'tel'=>"Numéro de téléphone",
            'password'=>"Mot de passe",
            "success-txt"=>"Un code de vérification a été envoyé à votre adresse e-mail"
        ],
        "second-f"=>[
            "instruction"=>"Entrez le code de vérification qui vous a été envoyé",
            "new-code-btn"=>"Obtenir un nouveau code de vérification",
            'email'=>"Email",
            "code"=>"Code de vérification",
            'code-err'=>"Le code de vérification n'est pas valide"
        ]
    ]
,
    "forget-pwd"=>[
        "first-f"=>[
            "instruction"=>"Votre email doit être validé, un code de vérification vous sera envoyé",
            "email"=>"Email",
            "success-txt"=>"Un code de vérification a été envoyé à votre adresse e-mail"
        ],
        "second-f"=>[
            "instruction"=>"Entrez le code de vérification qui vous a été envoyé",
            'email'=>"Email",
            "code"=>"Code de vérification",
            "password"=>"Le nouveau mot de passe",
            "no-user"=>"Aucun utilisateur correspondant trouvé avec l'e-mail fourni",
            "code-err"=>"Le code de vérification n'est pas valide"
        ]
        ],
        "change-email" => [
            "instruction" => "Votre nouveau email doit être valide",
            'old-email' => "Ancien Email",
            "new-email" => "Nouveau Email",
            "pwd" => "Mot de passe",
            "no-user" => "Vérifiez votre ancien e-mail ou votre mot de passe",
            "success-txt" => "Votre e-mail a été changé.Vous serez maintenant déconnecté(e)"
        ],
    "change-pwd" => [
        "instruction" => "Veuillez fournir les informations suivantes :",
        "pwd" => "Ancien mot de passe",
        "new-pwd" => "Nouveau mot de passe",
        "pwd-err" => "Vérifiez votre ancien mot de passe",
        "success-txt" => "Votre mot de passe a été modifié. Vous serez maintenant déconnecté(e)."
    ]
    ,
    "site-params"=>[
        "first-f"=>[
            "instruction"=>"Veuillez fournir les informations suivantes :",
            "email"=>"Email",
            "password"=>"Mot de passe",
            "no-user"=>"Aucun utilisateur correspondant trouvé avec l'email et le mot de passe fournis",
            "no-access"=>"Vous n'avez pas le droit d'accéder à l'étape suivante",
            "success-txt"=>"Soyez prudent lors du changement de l'état global de la plateforme"
        ],
        "second-f"=>[
            "instruction"=>"Gérer l'état de maintenance de la plateforme :",
            "disable"=>"Désactiver",
            "enable"=>"Activer",
            "db-download-btn"=>"Télécharger la base de données",
            "no-db"=>"Aucune sauvegarde de base de données disponible.",
            "state"=>"L'état de maintenance de la plateforme",
            "success-txt"=>"Vous avez changé avec succès l'état de maintenance"
        ]
        ],
        "user" => [
            "tel-match-err" => "Le numéro de téléphone doit commencer par 05, 06 ou 07, suivi d'une séquence précise de 8 chiffres.",
            "add" => [
                "success-txt" => "L'utilisateur a été créé avec succès",
            ],
            "update" => [
                "success-txt" => "L'utilisateur a été mis à jour avec succès",
            ]
            ],
            'classroom' => [
                'img-err' => 'L\'image doit être au format image',
                'add' => [
                    'success-txt' => 'La salle de classe a été créée avec succès',
                ],
                'update' => [
                    'success-txt' => 'La salle de classe a été mise à jour avec succès',
                ],
            ],
            'product' => [
                'img-err' => 'L\'image doit être au format image',
                'add' => [
                    'success-txt' => 'Le produit a été créé avec succès',
                ],
                'update' => [
                    'success-txt' => 'Le produit a été mis à jour avec succès',
                ],
            ],
            'training' => [
                'add' => [
                    'success-txt' => 'La formation a été créée avec succès',
                ],
                'update' => [
                    'success-txt' => 'La formation a été mise à jour avec succès',
                ],
            ],
"landing" => [
                "landline" => "Numéro de téléphone fixe",
                "phone" => "Numéro de téléphone",
                "fax" => "Fax",
                "map" => "Google Map",
                "email" => "Email",
                "logo" => "Changer le logo",
                'update' => [
                    'success-txt' => 'La page d\'accueil a été mise à jour avec succès',
                         ],
            ],
            'hero' => [
                'title-fr' => 'Titre en français',
                'title-ar' => 'Titre en arabe',
                'sub-title-fr' => 'Sous-titre en français',
                'sub-title-ar' => 'Sous-titre en arabe',
                'image' => 'Mettre à jour les images',
                'update' => [
                    'success-txt' => 'La section de bienvenue a été mis à jour avec succès',
                ],
            ],


            'aboutUs' => [
                'titleFr' => 'Titre en français',
                'titleAr' => 'Titre en arabe',
                'descriptionAr' => 'Description en arabe',
                'descriptionFr' => 'Description en français',
                'image' => 'Changer l\'image',
                'update' => [
                    'success-txt' => 'La page À propos de nous a été mise à jour avec succès',
                ],
            ],
'ourQuality' => [
                'nameFr' => 'Nom en français',
                'nameAr' => 'Nom en arabe',
                'image' => 'Changer l\'image',
                'add' => [
                    'success-txt' => 'La qualité a été ajoutée avec succès',
                ],
                'update' => [
                    'success-txt' => 'La qualité a été mise à jour avec succès',
                ],
            ],
'socials' => [
                'youtube' => 'Youtube',
                'facebook' => 'Facebook',
                'github' => 'Github',
                'tiktok' => 'TikTok',
                'instagram' => 'Instagram',
                'linkedin' => 'Linkedin',
                'update' => [
                    'success-txt' => 'Vos réseaux sociaux ont été mis à jour avec succès',
                ],
            ],

"reservation"=>[
    'add' => [
                'success-txt' => 'Vous avez réservé cette salle de classe avec succès',
            ],
        ],
'message' => [
            'name' => 'Nom',
            'message' => 'Message',
            'email' => 'Email',
            'add' => [
                'success-txt' => 'Votre message a été envoyé avec succès',
            ],
        ],
];
