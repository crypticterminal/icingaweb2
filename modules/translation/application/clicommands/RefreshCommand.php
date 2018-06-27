<?php
/* Icinga Web 2 | (c) 2014 Icinga Development Team | GPLv2+ */

namespace Icinga\Module\Translation\Clicommands;

use Icinga\Module\Translation\Cli\TranslationCommand;
use Icinga\Module\Translation\Util\GettextTranslationHelper;

/**
 * Translation updater
 *
 * This command will create a new or update any existing PO-file of a domain. The
 * actions below allow to select a particular domain for whom to touch the PO-file.
 *
 * Domains are the global one 'icinga' and all available and enabled modules
 * identified by their name.
 *
 * Once a PO-file has been created/updated one can open it with a editor for
 * PO-files and start with the actual translation.
 */
class RefreshCommand extends TranslationCommand
{
    /**
     * Touch the global domain
     *
     * This will create/update the POT-file of the global 'icinga' domain,
     * and the PO-file when a locale is specified
     *
     * USAGE:
     *
     *   icingacli translation refresh icinga [<locale>]
     *
     * EXAMPLES:
     *
     *   icingacli translation refresh icinga
     *   icingacli translation refresh icinga de_DE
     *   icingacli translation refresh icinga fr_FR
     */
    public function icingaAction()
    {
        $locale = $this->params->shift();

        $helper = $this->getTranslationHelper($locale);

        if ($locale) {
            $this->validateLocaleCode($locale);
            $helper->updateIcingaTranslations();
        } else {
            $helper->updateIcingaTemplate();
        }
    }

    /**
     * Touch a module domain
     *
     * This will create/update the POT file for a given module domain,
     * and the PO-file when a locale is specified
     *
     * USAGE:
     *
     *   icingacli translation refresh module <module> [<locale>]
     *
     * EXAMPLES:
     *
     *   icingacli translation refresh module monitoring
     *   icingacli translation refresh module monitoring de_DE
     *   icingacli translation refresh module monitoring fr_FR
     */
    public function moduleAction()
    {
        $module = $this->validateModuleName($this->params->shift());
        $locale = $this->params->shift();

        $helper = $this->getTranslationHelper($locale);
        if ($locale) {
            $this->validateLocaleCode($locale);
            $helper->updateModuleTranslations($module);
        } else {
            $helper->updateModuleTemplate($module);
        }
    }
}
