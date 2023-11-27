<div>
    <!-- APIトークン生成フォーム -->
    <x-jet-form-section submit="createApiToken">
        <!-- タイトル -->
        <x-slot name="title">
            {{ __('Create API Token') }}
        </x-slot>

        <!-- 説明 -->
        <x-slot name="description">
            {{ __('API tokens allow third-party services to authenticate with our application on your behalf.') }}
        </x-slot>

        <x-slot name="form">
            <!-- トークン名 -->
            <!-- ユーザーがトークンの名前を入力するフォーム -->
        </x-slot>

        <x-slot name="actions">
            <!-- アクションメッセージ -->
            <x-jet-action-message class="mr-3" on="created">
                {{ __('Created.') }}
            </x-jet-action-message>

            <!-- トークン生成ボタン -->
            <x-jet-button>
                {{ __('Create') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <!-- APIトークン管理セクション -->
    <!-- ユーザーのトークン一覧を表示 -->
    @if ($this->user->tokens->isNotEmpty())
        <!-- ヘッダー -->
        <x-jet-section-border />
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <!-- タイトルと説明 -->
                <x-slot name="title">
                    {{ __('Manage API Tokens') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('You may delete any of your existing tokens if they are no longer needed.') }}
                </x-slot>

                <!-- トークン一覧 -->
                <x-slot name="content">
                    <!-- ユーザーのトークン一覧を表示 -->
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    <!-- トークン値モーダル -->
    <!-- APIトークンの値を表示するモーダル -->
    
    <!-- APIトークン権限設定モーダル -->
    <!-- APIトークンの権限を設定するモーダル -->

    <!-- トークン削除確認モーダル -->
    <!-- APIトークンを削除するための確認モーダル -->
</div>
