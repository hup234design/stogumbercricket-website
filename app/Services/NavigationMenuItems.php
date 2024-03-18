<?php

namespace App\Services;

use App\Models\Page;

class NavigationMenuItems
{
    public static function transform($items = [])
    {
        return self::transformItems($items);
    }

    private static function transformItems($items) {
        $transformedItems = [];

        foreach ($items as $item) {
            $href = null;
            $target = '_self';
            $dropdown = false;

            switch($item['type']) {
                case 'dropdown':
                    $dropdown = true;
                    break;

                case 'home':
                    $href = route('home');
                    break;

                case 'page':
                    if ($page = Page::find($item['data']['id'])) {
                        if( $page->type == "index")
                        {
                            switch ($page->slug) {
                                case "events":
                                    $href = cms('events_enabled') ? route('events') ?? null : null;
                                    break;
                                case 'services':
                                    $href = cms('services_enabled') ? route('services') ?? null : null;
                                    break;
                                default:
                                    $href = route($page->slug) ?? null;
                                    break;
                            }
                        }
                        else {
                            $href = route('page', $page->slug);
                        }
                    }
                    break;

                case 'external-link':
                    $href   = $item['data']['url'];
                    $target = $item['data']['target'] ?? '_self';
                    break;
            }

            // If the model (Page, Post or External Link) was processed and the route was generated
            if ($dropdown || $href) {
                $transformed = [
                    'label'    => $item['label'],
                    'href'     => $href,
                    'target'   => $target,
                    'dropdown' => $dropdown,
                    'children' => null,
                ];

                // If there are children, transform them recursively
                if (!empty($item['children'])) {
                    $transformed['dropdown'] = true;
                    $transformed['children'] = self::transformItems($item['children']);
                }

                $transformedItems[] = $transformed;
            }
        }

        return $transformedItems;
    }

}
