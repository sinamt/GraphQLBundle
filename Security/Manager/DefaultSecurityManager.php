<?php
/**
 * Date: 29.08.16
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQLBundle\Security\Manager;


use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Parser\Ast\Query;

class DefaultSecurityManager implements SecurityManagerInterface
{

    private bool $fieldSecurityEnabled = false;

    private bool $rootOperationSecurityEnabled = false;

    public function __construct(private AuthorizationCheckerInterface $authorizationChecker, array $guardConfig = [])
    {
        $this->fieldSecurityEnabled         = $guardConfig['field'] ?? false;
        $this->rootOperationSecurityEnabled = $guardConfig['operation'] ?? false;
    }

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function isSecurityEnabledFor($attribute)
    {
        if (SecurityManagerInterface::RESOLVE_FIELD_ATTRIBUTE == $attribute) {
            return $this->fieldSecurityEnabled;
        } else if (SecurityManagerInterface::RESOLVE_ROOT_OPERATION_ATTRIBUTE == $attribute) {
            return $this->rootOperationSecurityEnabled;
        }

        return false;
    }

    /**
     * @param boolean $fieldSecurityEnabled
     */
    public function setFieldSecurityEnabled($fieldSecurityEnabled)
    {
        $this->fieldSecurityEnabled = $fieldSecurityEnabled;
    }

    /**
     * @param boolean $rootOperationSecurityEnabled
     */
    public function setRooOperationSecurityEnabled($rootOperationSecurityEnabled)
    {
        $this->rootOperationSecurityEnabled = $rootOperationSecurityEnabled;
    }

    /**
     * @return bool
     */
    public function isGrantedToOperationResolve(Query $query)
    {
        return $this->authorizationChecker->isGranted(SecurityManagerInterface::RESOLVE_ROOT_OPERATION_ATTRIBUTE, $query);
    }

    /**
     * @return bool
     */
    public function isGrantedToFieldResolve(ResolveInfo $resolveInfo)
    {
        return $this->authorizationChecker->isGranted(SecurityManagerInterface::RESOLVE_FIELD_ATTRIBUTE, $resolveInfo);
    }

    /**
     *
     * @return mixed
     * @throw \Exception
     */
    public function createNewFieldAccessDeniedException(ResolveInfo $resolveInfo)
    {
        return new AccessDeniedException();
    }

    /**
     *
     * @return mixed
     * @throw \Exception
     */
    public function createNewOperationAccessDeniedException(Query $query)
    {
        return new AccessDeniedException();
    }
}
