{{-- 个人收藏组件 --}}
<template id="conllecttmp">
  <div class="laui-row">
    <div class="member-content-header">
      <h3>个人收藏</h3>
    </div>
    <div id="member_conllect_article_box" v-if="parentData.length != 0">
      <div v-for="item in parentData" :key="item.aid"  class="panel panel-default">
        <div class="panel-heading">
        <a :href="'/detail/'+item.aid">@{{item.title}}</a>
        <span @click="cancelCollection(item.aid)">取消收藏</span>
        </div>
        <div class="panel-body">
        <p>简介：@{{item.descs}}</p>
        <dl style="display:flex;justify-content:flex-end;margin-top:10px;">
          <dd>作者：@{{item.author}}</dd>
          <dd style="margin-left:30px">@{{item.created_at}}</dd>
        </dl>           
        </div>
      </div>
    </div>
    <div id="member_conllect_article_box" v-else>
      <div>
        <h1 style="margin-top:180px;text-align:center;">这里空空如也</h1>
      </div>
    </div>
  </div>
</template>
