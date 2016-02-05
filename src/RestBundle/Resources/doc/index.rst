AsiAdvertBundle
===============

Rôle
----

Ce bundle donne une définition commune à toutes les ressources (entités exposées par REST) et expose des services permettant leur manipulation.

Entités principales
-------------------

* Resource: donne la définition d'une entité Resource
* RichResource: donne la définition d'une Resource riche (peut être supprimée, a des dates de création et d'update)

Services principaux
-------------------

* ResourceManager: permet de manipuler des entités (proche du rôle de Doctrine\EntityManager)