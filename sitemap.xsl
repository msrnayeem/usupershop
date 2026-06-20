<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>XML Sitemap - U Super Shop</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<style type="text/css">
					body {
						font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
						color: #333;
						margin: 0;
						padding: 40px;
						background-color: #f4f7f9;
					}
					.container {
						max-width: 1000px;
						margin: 0 auto;
						background: #fff;
						padding: 40px;
						border-radius: 12px;
						box-shadow: 0 4px 20px rgba(0,0,0,0.08);
					}
					h1 {
						color: #006680;
						margin-bottom: 10px;
						font-size: 28px;
					}
					p {
						font-size: 14px;
						color: #666;
						margin-bottom: 30px;
					}
					table {
						width: 100%;
						border-collapse: collapse;
						margin-top: 20px;
					}
					th {
						text-align: left;
						background-color: #f8fbff;
						padding: 15px 10px;
						border-bottom: 2px solid #eef2f7;
						color: #006680;
						font-size: 13px;
						text-transform: uppercase;
						letter-spacing: 0.5px;
					}
					td {
						padding: 12px 10px;
						border-bottom: 1px solid #f0f4f8;
						font-size: 14px;
					}
					tr:hover td {
						background-color: #f9fbfd;
					}
					a {
						color: #008eb3;
						text-decoration: none;
					}
					a:hover {
						text-decoration: underline;
					}
					.priority-bar {
						height: 6px;
						background: #e0e0e0;
						border-radius: 3px;
						width: 50px;
						display: inline-block;
						vertical-align: middle;
						margin-right: 8px;
					}
					.priority-fill {
						height: 100%;
						background: #00d084;
						border-radius: 3px;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<h1>XML Sitemap</h1>
					<p>Total URLs in this sitemap: <strong><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></strong></p>
					<table>
						<thead>
							<tr>
								<th>URL</th>
								<th>Priority</th>
								<th>Change Freq.</th>
								<th>Last Modified (GMT)</th>
							</tr>
						</thead>
						<tbody>
							<xsl:for-each select="sitemap:urlset/sitemap:url">
								<tr>
									<td>
										<a href="{sitemap:loc}">
											<xsl:value-of select="sitemap:loc"/>
										</a>
									</td>
									<td>
										<div class="priority-bar">
											<div class="priority-fill" style="width: {sitemap:priority * 100}%"></div>
										</div>
										<xsl:value-of select="format-number(sitemap:priority, '0%')"/>
									</td>
									<td>
										<xsl:value-of select="sitemap:changefreq"/>
									</td>
									<td>
										<xsl:value-of select="concat(substring(sitemap:lastmod, 0, 11), ' ', substring(sitemap:lastmod, 12, 8))"/>
									</td>
								</tr>
							</xsl:for-each>
						</tbody>
					</table>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
