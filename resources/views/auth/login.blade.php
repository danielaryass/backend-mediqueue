<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('/css/output.css') }}" rel="stylesheet" />
    <title>Sign In - Klinik APP</title>
  </head>
  <body
    class="min-h-screen w-full flex justify-center items-center bg-slate-950"
  >
    <div
      class="max-w-5xl h-96 md:h-[600px] font-bold bg-slate-800 flex rounded-xl overflow-hidden"
    >
      <div class="w-1/2 hidden md:block">
        <img src="{{asset('/image/hello.jpeg')}}" alt="" class="w-full h-full object-cover" />
      </div>
      <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
        <h2 class="text-white text-3xl mb-8">Sign In to Klinik App</h2>

        <form class="p-2 w-full" method="POST" action="{{ route('login') }}">
          @csrf
                <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-white"
              >Email address</label
            >
            <input
              class="bg-gray-50 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="john.doe@company.com"
              id="email"
              type="email"
              name="email"
              :value="old('email')"
              required
              autofocus
              autocomplete="username"
            />
          </div>
          <div class="mb-6">
            <label
              for="password"
              class="block mb-2 text-sm font-medium text-white"
              >Password</label
            >
            <input
              id="password"
              class="bg-gray-50 border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="•••••••••"
              type="password"
              name="password"
              required
              autocomplete="current-password"
            />
          </div>
          <button
            type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-md w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >
            Login
          </button>
        </form>
      </div>
    </div>
  </body>
</html>
