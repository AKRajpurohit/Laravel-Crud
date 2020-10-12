<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="Laravelcrud_0"></a>Laravel-crud</h1>
<p class="has-line-data" data-line-start="3" data-line-end="4">Laravel-crud is basic crud operations of products and category.</p>
<h1 class="code-line" data-line-start=5 data-line-end=6 ><a id="Environment_Requirement_5"></a>Environment Requirement</h1>
<p class="has-line-data" data-line-start="6" data-line-end="7">The Laravel framework has a few system requirements. Of course, all of these requirements are satisfied by the Laravel Homestead virtual machine, so it’s highly recommended that you use Homestead as your local laravel development environment.</p>
<p class="has-line-data" data-line-start="8" data-line-end="9">However, if you are not using Homestead, you will need to make sure your server meets the following requirements:</p>
<ul>
<li class="has-line-data" data-line-start="10" data-line-end="11">PHP &gt;= 7.2.5</li>
<li class="has-line-data" data-line-start="11" data-line-end="12">OpenSSL PHP Extension</li>
<li class="has-line-data" data-line-start="12" data-line-end="13">PDO PHP Extension</li>
<li class="has-line-data" data-line-start="13" data-line-end="15">Mbstring PHP Extension</li>
</ul>
<h3 class="code-line" data-line-start=15 data-line-end=16 ><a id="Installation_15"></a>Installation</h3>
<pre><code class="has-line-data" data-line-start="17" data-line-end="28" class="language-sh">$ git <span class="hljs-built_in">clone</span> -b &lt;branch&gt;  https://github.com/AKRajpurohit/Laravel-Crud.git
$ <span class="hljs-built_in">cd</span> &lt;your project directory&gt;
$ cp .env.example .env
$ configure database .env
$ sudo chmod -R <span class="hljs-number">0777</span> storage/ and bootstrap
$ composer install
$ php artisan migrate
$ php artisan storage:link
$ php artisan vendor:publish --provider=<span class="hljs-string">"Intervention\Image\ImageServiceProviderLaravelRecent"</span>
$ php artisan key:generate
$ php artisan serve
</code></pre>
