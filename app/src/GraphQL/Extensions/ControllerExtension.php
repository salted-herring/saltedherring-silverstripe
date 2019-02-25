<?php
/**
 * ControllerExtension
 * @author Simon Winter <simon@saltedherring.com>
 *
 * Override the default GraphQL controller to make sure it allows for
 * Accress Credentials headers.
 *
 * */
namespace App\Web\GraphQL\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class GraphQLController extends DataExtension
{
    public function updateCorsHeaders($response)
    {
        $response->addHeader('Access-Control-Allow-Credentials', 'true');
    }
}
