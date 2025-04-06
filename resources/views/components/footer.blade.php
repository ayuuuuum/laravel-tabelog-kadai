<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <!-- ロゴ部分 -->
        <a href="{{ url('/') }}" class="text-center mb-3 d-block text-decoration-none">
            <span class="logo-text fs-2">NAGOYAMESHI</span>
        </a>

        <!-- 会社概要・利用規約リンク -->
        <div class="mt-3">
            <a href="{{ route('company') }}" class="text-decoration-none text-white me-4 fs-5">会社概要</a>
            <a href="{{ route('terms') }}" class="text-decoration-none text-white fs-5">利用規約</a>
        </div>

        <!-- 著作権表示 -->
        <div class="mt-3">
            <span>&copy; NAGOYAMESHI All rights reserved.</span>
        </div>
    </div>
</footer>
