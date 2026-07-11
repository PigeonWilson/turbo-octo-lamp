<?php
if (!defined('prevent_direct_access'))
{
    // prevent direct access to this file
    die();
}
?>
<footer>
    <div class="container">
        <?php echo project_name . ' v' . project_version;?>
        |
        <a target="_blank" href="<?php echo web_status_url; ?>">Status</a>
        |
        <a target="_blank" href="<?php echo project_source_code_link; ?>">Code source</a>
        |
        <a target="_blank" href="<?php echo project_source_code_license_link; ?>">Licence</a>
        |
        <a target="_blank" href="<?php echo project_documentation_link; ?>">Documentation</a>
        |
        <a target="_blank" href="<?php echo project_multimedia_credits_link; ?>">Crédits multimédia</a>
    </div>
</footer>
