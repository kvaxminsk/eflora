<h1>Карта сайта</h1>
<table id="cont" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<td>
				<a class="rightLink" href="<?=$host?>">Главная</a>
				После загрузки данной страницы, обновляется файл <a href="<?=$host?>/sitemap.xml">/sitemap.xml</a>
			</td>
		</tr>
	</thead>
	
	<tfoot>
		<tr>
			<td>
				Created by SM.CMS &copy; 
				<a target="_blank" href="https://sitemania.by">Создание и поддержка веб-сайта - SiteMania</a>
			</td>
		</tr>
	</tfoot>
	
	<tbody>
	<? foreach($data as $v): ?>
		<tr>
			<td>
				<a href="<?=$v['url']?>" title="<?=$v['name']?>"><?=$v['name']?></a>
			</td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>
