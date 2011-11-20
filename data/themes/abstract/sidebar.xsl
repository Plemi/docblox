<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output indent="yes" method="html" />
    <xsl:include href="chrome.xsl" />
    <xsl:include href="sidebar/header.xsl" />
    <xsl:include href="sidebar/sections.xsl" />
    <xsl:include href="sidebar/footer.xsl" />

    <xsl:template name="content">
        <!--<script type="text/javascript" src="{$root}js/sidebar.js"></script>-->

        <div id="sidebar">
            <div id="sidebar-header">
                <xsl:call-template name="sidebar-header"/>
            </div>

            <div id="sidebar-nav">
                <xsl:call-template name="sidebar-sections"/>
            </div>

            <div id="sidebar-footer">
                <xsl:call-template name="sidebar-footer"/>
            </div>
        </div>

    </xsl:template>

</xsl:stylesheet>