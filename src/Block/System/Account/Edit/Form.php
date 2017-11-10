<?php
/**
 * @category    Qextensions
 * @package     Qextensions\Google2factor
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Qextensions\Google2factor\Block\System\Account\Edit;


class Form extends \Magento\Backend\Block\System\Account\Edit\Form
{
    /**
     * {@inheritdoc}
     */
    protected function _prepareForm()
    {
        $userId = $this->_authSession->getUser()->getId();
        $user = $this->_userFactory->create()->load($userId);
        $user->unsetData('password');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Account Information')]);

        $fieldset->addField(
            'username',
            'text',
            ['name' => 'username', 'label' => __('User Name'), 'title' => __('User Name'), 'required' => true]
        );

        $fieldset->addField(
            'firstname',
            'text',
            ['name' => 'firstname', 'label' => __('First Name'), 'title' => __('First Name'), 'required' => true]
        );

        $fieldset->addField(
            'lastname',
            'text',
            ['name' => 'lastname', 'label' => __('Last Name'), 'title' => __('Last Name'), 'required' => true]
        );

        $fieldset->addField('user_id', 'hidden', ['name' => 'user_id']);

        $fieldset->addField(
            'email',
            'text',
            ['name' => 'email', 'label' => __('Email'), 'title' => __('User Email'), 'required' => true]
        );

        $fieldset->addField(
            'password',
            'password',
            [
                'name' => 'password',
                'label' => __('New Password'),
                'title' => __('New Password'),
                'class' => 'validate-admin-password admin__control-text'
            ]
        );

        $fieldset->addField(
            'confirmation',
            'password',
            [
                'name' => 'password_confirmation',
                'label' => __('Password Confirmation'),
                'class' => 'validate-cpassword admin__control-text'
            ]
        );

        $fieldset->addField(
            'interface_locale',
            'select',
            [
                'name' => 'interface_locale',
                'label' => __('Interface Locale'),
                'title' => __('Interface Locale'),
                'values' => $this->_localeLists->getTranslatedOptionLocales(),
                'class' => 'select'
            ]
        );

        $fieldset->addField(
            'google2factor_enabled',
            'select',
            [
                'name' => 'google2factor_enabled',
                'label' => __('Two-factor Authentication'),
                'title' => __('Two-factor Authentication'),
                'values' => [['value' => 0, 'label' => __('No')], ['value' => 1, 'label' => __('Yes')]],
                'class' => 'select'
            ]
        );

        $verificationFieldset = $form->addFieldset(
            'current_user_verification_fieldset',
            ['legend' => __('Current User Identity Verification')]
        );
        $verificationFieldset->addField(
            self::IDENTITY_VERIFICATION_PASSWORD_FIELD,
            'password',
            [
                'name' => self::IDENTITY_VERIFICATION_PASSWORD_FIELD,
                'label' => __('Your Password'),
                'id' => self::IDENTITY_VERIFICATION_PASSWORD_FIELD,
                'title' => __('Your Password'),
                'class' => 'validate-current-password required-entry admin__control-text',
                'required' => true
            ]
        );

        $data = $user->getData();
        unset($data[self::IDENTITY_VERIFICATION_PASSWORD_FIELD]);
        $form->setValues($data);
        $form->setAction($this->getUrl('adminhtml/system_account/save'));
        $form->setMethod('post');
        $form->setUseContainer(true);
        $form->setId('edit_form');

        $this->setForm($form);

        return \Magento\Backend\Block\Widget\Form\Generic::_prepareForm();
    }
}