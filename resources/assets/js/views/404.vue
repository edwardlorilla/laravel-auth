<template>
    <div class="content--wrap">
        <div lang="en" class="container fill-height">
            <div class="layout align-center">
                <div class="flex text-xs-center">
                    <h1 class="display-2 primary--text">Whoops, 404</h1>
                    <p>The page you were looking for does not exist</p>
                    <a @click="$router.push({path: '/'})" class="btn btn--outline btn--depressed btn--router primary--text">
                        <div class="btn__content">Get me out of here!</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
