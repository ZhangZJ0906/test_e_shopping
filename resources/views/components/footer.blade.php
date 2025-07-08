<footer class="bg-white dark:bg-gray-900 mt-20">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                <span class="text-lg text-gray-500 sm:text-center dark:text-gray-400">Copyright &copy;
                    {{ $currentYear }} | {{ $companyName }} All Rights Reserved 抄襲必定追究 </span>
            </div>
            <div class="mb-4">
                <span class="mr-5 text-lg text-gray-500 sm:text-center dark:text-gray-400 font-semibold ">快速連結</span>
                @foreach ($footerLinks as $item => $url)
                    <a class="mr-4 hover:underline md:mr-6 text-sm text-gray-500 dark:text-gray-400"
                        href="{{ $url }}"> {{ $item }}</a>
                @endforeach
            </div>

        </div>
        <div class="mb-4 text-sm text-gray-500 sm:text-center dark:text-gray-400">
            <div class="flex flex-row gap-4 justify-center mt-4">
                {{-- Facebook 按鈕 --}}
                <button type="button" onclick="window.open('{{ $socialMediaLinks['facebook'] }}', '_blank')"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-[#3b5998] text-white hover:bg-white hover:text-[#3b5998] transition">
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
                    </svg>
                </button>
                {{-- 第二顆如果要換 icon/連結直接複製改掉即可 --}}
                <button type="button" onclick="window.open('{{ $socialMediaLinks['instagram'] }}', '_blank')"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-red-500 text-white hover:bg-white hover:text-red-500 transition">
                    <svg class="w-6 h-6 fill-current " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                    </svg>
                </button>

                <button type="button" onclick="window.open('{{ $socialMediaLinks['twitter'] }}', '_blank')"
                    class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white hover:bg-white hover:text-black transition">
                    <svg class="w-6 h-6 fill-current " xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100"
                        height="100" viewBox="0 0 50 50">
                        <path
                            d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z">
                        </path>
                    </svg>
                </button>

            </div>
        </div>

        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
    </div>
</footer>
