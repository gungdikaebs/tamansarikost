<template>
    <div class="bg-[#EDF3FF] min-h-screen text-gray-900 flex items-center ">
        <div class="max-w-screen-xl mx-auto bg-white flex p-2 rounded-xl shadow-lg">
            <div class="flex-1 ml-10 flex flex-col gap-4">
                <h1>
                    <a href="/register" class="text-2xl font-bold">.Taman Sari Kost</a>
                </h1>
                <div>
                    <h2 class="text-2xl font-semibold ">
                        Register
                    </h2>
                    <p class="text-gray-600">silahkan melakukan Register</p>
                </div>
                <div class="flex flex-col">
                    <div class="flex flex-col">
                        <label for="register">Email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="flex flex-col">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username">
                    </div>
                    <div class="flex flex-col">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password">
                    </div>
                </div>
                <div>
                    <button>register</button>
                </div>
            </div>
            <div class="flex-1"> <img
                    src="https://cdn.dribbble.com/userupload/16517492/file/original-e75c7ce430e32b50b9860d3b2bccfaee.png?resize=2048x1536&vertical=center"
                    alt=""></div>
        </div>
    </div>

</template>