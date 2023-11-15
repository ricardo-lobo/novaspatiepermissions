<?php

namespace Itsmejoshua\Novaspatiepermissions;

use Illuminate\Http\Request;
use Laravel\Nova\Exceptions\NovaException;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;


class Novaspatiepermissions extends Tool
{
    public string $roleResource = Role::class;

    public string $permissionResource = Permission::class;

    public bool $registerCustomResources = false;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void
    {
        if ((Role::class === $this->roleResource && Permission::class === $this->permissionResource) || $this->registerCustomResources) {
            Nova::resources([
                $this->roleResource,
                $this->permissionResource,
            ]);
        }

    }

    public function roleResource(string $roleResource): static
    {
        $this->roleResource = $roleResource;

        return $this;
    }

    public function permissionResource(string $permissionResource): static
    {
        $this->permissionResource = $permissionResource;

        return $this;
    }

    public function withRegistration(): static
    {
        $this->registerCustomResources = true;

        return $this;
    }


    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  Request  $request
     * @return array
     * @throws NovaException
     */
    public function menu(Request $request)
    {

        return [
            MenuSection::make(__('nova-spatie-permissions::lang.sidebar_label'), [
                MenuItem::link(__('nova-spatie-permissions::lang.sidebar_label_roles'), 'resources/roles'),
                MenuItem::link(__('nova-spatie-permissions::lang.sidebar_label_permissions'), 'resources/permissions'),
            ])->icon('key')->collapsable(),
        ];
    }
}

