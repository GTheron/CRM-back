# language: fr
Fonctionnalité: gestion des notifications

    Les utilisateurs devraient pouvoir récupérer les notifications qui leurs sont associés
    et les supprimer lorsqu'ils les on vu

    Scénario: recupérer et supprimer une notif


//TODO ecrire la phrase ou il y tant d item ( notif)  dans la reponse du cget
//je stock dnas id precedent l id d un des


        Étant donné que je veux trouver une "notification"
        Et que je charge les fixtures
        Et que je suis identifié en tant que "admin"
        Quand je demande "get_notifications"
        Alors le code de la réponse devrait être 200

        Et le nombre d'element dans la réponse est "3"
        Et la réponse contient un attribut "text" qui vaut "featuretextq"
        Et je recupere un des id contenu dans la réponse pour le mettre dans id précédent

        Étant donné que je veux modifier une "notification"
        Quand je demande "put_notification" avec l'id précédent
        Alors le code de la réponse devrait être 200








