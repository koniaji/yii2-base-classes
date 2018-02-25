<?php
/**
 * Created by PhpStorm.
 * User: zvinger
 * Date: 21.02.18
 * Time: 17:21
 */

namespace Zvinger\BaseClasses\app\modules\api\admin\v1\components\user;

use Zvinger\BaseClasses\app\models\work\user\object\VendorUserObject;
use Zvinger\BaseClasses\app\modules\api\admin\v1\components\user\models\UserApiAdminV1Model;

class VendorAdminUserComponent
{
    /**
     * @param VendorUserObject $userObject
     * @return UserApiAdminV1Model
     */
    public function convertUserObjectToModel(VendorUserObject $userObject)
    {
        return new UserApiAdminV1Model([
            'username' => $userObject->username,
            'email'    => $userObject->email,
            'id'       => $userObject->id,
            'status'   => $userObject->status,
        ]);
    }

    /**
     * @param VendorUserObject[] $userObjects
     * @return UserApiAdminV1Model[]
     */
    public function convertUserObjectsToModelMultiple(array $userObjects)
    {
        $result = [];
        foreach ($userObjects as $userObject) {
            $result[] = $this->convertUserObjectToModel($userObject);
        }

        return $result;
    }
}