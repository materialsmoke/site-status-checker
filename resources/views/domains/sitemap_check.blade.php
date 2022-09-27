
<div class="p-6 bg-white border-b border-gray-200" lang="en-us">

    {{$domain->name}}

</div>

<div id="report"></div>

<script>
    let domainId = "{{$domain->id}}";
    fetch(`/api/check-sitemaps-domains/${domainId}`).then(res => res.json()).then(data => {
        console.log(data);
        let report = document.getElementById('report');
        data.data.forEach(item => {
            const div = document.createElement('div');
            const span1 = document.createElement('span');
            const id = document.createTextNode(item.id);
            span1.appendChild(id);
            span1.style.color = 'red';
            span1.style.padding = '15px'
            div.appendChild(span1);
            
            const span2 = document.createElement('span');
            const createdAt = document.createTextNode(item.created_at);
            span2.style.color = 'blue';
            span2.style.padding = '15px'
            span2.appendChild(createdAt);
            div.appendChild(span2);
            
            const span3 = document.createElement('span');
            const status = document.createTextNode(item.status);
            span3.style.color = 'purple';
            span3.style.padding = '15px'
            span3.appendChild(status);
            div.appendChild(span3);

            const span4 = document.createElement('span');
            const isHealthy = document.createTextNode(item.is_healthy ? 'yes' : 'no');
            span4.style.color = 'green';
            span4.style.padding = '15px'
            span4.appendChild(isHealthy);
            div.appendChild(span4);

            report.appendChild(div);
        });

    });
</script>