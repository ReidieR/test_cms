<div id="demo8">
  <div
    class="layui-box layui-laypage layui-laypage-default"
    id="layui-laypage-11">
    <span class="layui-laypage-limits">
      <select lay-ignore="">
        <option value="10" selected="">10 条/页</option>
        <option value="20">20 条/页</option>
        <option value="30">30 条/页</option>
        <option value="40">40 条/页</option>
        <option value="50">50 条/页</option>
      </select>
    </span>
    <a
      href="{{ $paginator->previousPageUrl() }}" 
      class="layui-laypage-prev layui-disabled"
      data-page="0"
      >上一页</a>
      <span class="layui-laypage-curr"
      ><em class="layui-laypage-em"></em><em>1</em></span
    ><a href="javascript:;" data-page="2">2</a
    ><a href="javascript:;" data-page="3">3</a
    ><a href="javascript:;" data-page="4">4</a
    ><a href="javascript:;" data-page="5">5</a
    ><span class="layui-laypage-spr">…</span
    ><a
      href="javascript:;"
      class="layui-laypage-last"
      title="尾页"
      data-page="100"
      >100</a
    ><a href="javascript:;" class="layui-laypage-next" data-page="2">下一页</a>
  </div>
</div>