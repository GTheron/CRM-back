<?php

namespace Core\RestBundle;

/**
 * @author Gabriel Theron <gabriel@class-web.fr>
 * @copyright Class-Web
 */
final class CoreRestEvents
{
    /**
     * Déclenché lorsqu'une ressource va être créée
     */
    const RESOURCE_WILL_CREATE = 'core_rest.resource.will_create';

    /**
     * Déclenché lorsqu'une ressource va être mise à jour
     */
    const RESOURCE_WILL_UPDATE = 'core_rest.resource.will_update';

    /**
     * Déclenché lorsqu'une ressource va être supprimée
     */
    const RESOURCE_WILL_DELETE = 'core_rest.resource.will_delete';

    /**
     * Déclenché lorsqu'une ressource va être vue
     */
    const RESOURCE_WILL_VIEW = 'core_rest.resource.will_view';

    /**
     * L'événément RESOURCE_CREATED est déclenché lorsqu'une ressource est créée.
     */
    const RESOURCE_CREATED = 'core_rest.resource.created';

    /**
     * L'événément RESOURCE_UPDATED est déclenché lorsqu'une ressource est modifiée.
     */
    const RESOURCE_UPDATED = 'core_rest.resource.updated';

    /**
     * L'événément RESOURCE_SAVED est déclenché à chaque fois que l'état d'une ressource est sauvegardé.
     */
    const RESOURCE_SAVED = 'core_rest.resource.saved';

    /**
     * L'événément RESOURCE_DELETED est déclenché lorsqu'une ressource est supprimée.
     */
    const RESOURCE_DELETED = 'core_rest.resource.deleted';

    /**
     * L'événement BEFORE_RESOURCE_VALIDATION est déclenché avant la validation d'une ressource.
     *
     * Il peut être utilisé pour modifier la ressource avant sa validation.
     */
    const BEFORE_RESOURCE_VALIDATION = 'core_rest.resource.before_validation';

    /**
     * L'événement RESOURCE_VALIDATION_SUCCESS est déclenché après qu'une ressource a été validée avec succès
     */
    const RESOURCE_VALIDATION_SUCCESS = 'core_rest.resource.validation_success';

    /**
     * L'événement RESOURCE_CHECK_CREATE est déclenché quand on veut vérifier que l'utilisateur en cours a le droit
     * de créer la ressource du type concerné
     */
    const RESOURCE_CHECK_CREATE = 'core_rest.resource.check_create';

    /**
     * L'événement RESOURCE_CHECK_UPDATE est déclenché quand on veut vérifier que l'utilisateur en cours a le droit
     * de modifier la ressource du type concerné
     */
    const RESOURCE_CHECK_UPDATE = 'core_rest.resource.check_update';

    /**
     * L'événement RESOURCE_CHECK_DELETE est déclenché quand on veut vérifier que l'utilisateur en cours a le droit
     * de supprimer la ressource du type concerné
     */
    const RESOURCE_CHECK_DELETE = 'core_rest.resource.check_delete';

    /**
     * L'événement RESOURCE_CHECK_VIEW est déclenché quand on veut vérifier que l'utilisateur en cours a le droit
     * de voir la ressource du type concerné
     */
    const RESOURCE_CHECK_VIEW = 'core_rest.resource.check_view';
}