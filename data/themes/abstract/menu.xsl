<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output indent="yes" method="html"/>
    <xsl:include href="sidebar/sections/charts.xsl"/>
    <xsl:include href="sidebar/sections/reports.xsl"/>

    <xsl:template name="page-menu">
        <style>
            td#db-menu {
                font-size: 0.8em;
                border-bottom: 1px solid silver;
            }

            td#db-menu ul {
                display: block;
            }

            td#db-menu li {
                float: right;
                padding-right: 10px;
            }
        </style>
        <ul>
            <xsl:call-template name="sidebar-section-charts"/>
            <xsl:call-template name="sidebar-section-reports"/>
        </ul>
    </xsl:template>

</xsl:stylesheet>