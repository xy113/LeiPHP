<div class="top">
    <div class="area">
        <div class="right">
            <ul>
                <li><a href="{U:('/')}">粗耕首页</a></li>
                <li class="pipe">|</li>
                <li><a href="{U:('m=member&c=index')}">我的粗耕</a></li>
                <li class="pipe">|</li>
                <li>
                    <a href="{U:('m=cart&c=index')}">
                        <span class="iconfont icon-cartfill"></span>
                        <span>购物车</span>
                    </a>
                </li>
                <li class="pipe">|</li>
                <li><a href="{U:('m=member&c=collection')}"><span class="iconfont icon-favorfill"></span> <span>收藏夹</span></a></li>
                <li class="pipe">|</li>
                <li>
                    <a href="{U:('m=item&c=catlog')}">
                        <span>商品分类</span>
                    </a>
                </li>
                <li class="pipe">|</li>
                <li><a href="{{url('/seller/index')}}">卖家中心</a></li>
                <li class="pipe">|</li>
                <li><a href="/pages/detail?pageid=42">联系客服</a></li>
            </ul>
        </div>
        {if $_G[islogin]}
        <span>Hi <a href="{{url('/member/index')}}" style="color: #f40;">{{$_G['username']}}</a>, 欢迎回来</span>
        <a href="{{url('/account/logout')}}">[退出登录]</a>
        {else}
        <span>Hi 欢迎回来</span>
        <a href="{{url('/account/login')}}">[登录]</a>
        <a href="{{url('/account/register')}}">[免费注册]</a>
        {/if}
    </div>
</div>
