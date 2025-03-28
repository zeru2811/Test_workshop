<footer class="bg-gray-900 text-white py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 md:gap-8">
        <div>
          <h4 class="font-['Pacifico'] text-xl md:text-2xl mb-4">logo</h4>
          <p class="text-xs md:text-sm text-gray-400" data-translate="footerTagline">
            Your trusted partner for all auto repair needs
          </p>
        </div>
        <div>
          <h4 class="font-semibold mb-2 md:mb-4 text-sm md:text-base" data-translate="quickLinks">Quick Links</h4>
          <ul class="space-y-1 md:space-y-2 text-xs md:text-sm text-gray-400">
            <li><a href="#" class="hover:text-white" data-translate="aboutUs">About Us</a></li>
            <li><a href="#" class="hover:text-white" data-translate="services">Services</a></li>
            <li><a href="#" class="hover:text-white" data-translate="locations">Locations</a></li>
            <li><a href="#" class="hover:text-white" data-translate="contact">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-2 md:mb-4 text-sm md:text-base" data-translate="services">Services</h4>
          <ul class="space-y-1 md:space-y-2 text-xs md:text-sm text-gray-400">
            <li><a href="#" class="hover:text-white" data-translate="oilChange">Oil Change</a></li>
            <li><a href="#" class="hover:text-white" data-translate="brakeService">Brake Service</a></li>
            <li><a href="#" class="hover:text-white" data-translate="tireRotation">Tire Rotation</a></li>
            <li><a href="#" class="hover:text-white" data-translate="engineRepair">Engine Repair</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-2 md:mb-4 text-sm md:text-base" data-translate="contactUs">Contact Us</h4>
          <ul class="space-y-1 md:space-y-2 text-xs md:text-sm text-gray-400">
            <li class="flex items-center">
              <i class="ri-phone-line w-4 h-4 flex items-center justify-center mr-2"></i>
              1-800-AUTO-HELP
            </li>
            <li class="flex items-center">
              <i class="ri-mail-line w-4 h-4 flex items-center justify-center mr-2"></i>
              support@autoworkshop.com
            </li>
          </ul>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-6 md:mt-8 pt-6 md:pt-8 text-center text-xs md:text-sm text-gray-400">
        <p data-translate="copyright">&copy; 2025 Auto Workshop Finder. All rights reserved.</p>
      </div>
    </div>
  </footer>  

  <script>
        // Mobile Menu Toggle
        function toggleMobileMenu() {
          const mobileMenu = document.getElementById('mobileMenu');
          mobileMenu.classList.toggle('hidden');
        }

        // Translations
        const translations = {
          'home': { en: 'Home', my: 'ပင်မ' },
          'services': { en: 'Services', my: 'ဝန်ဆောင်မှုများ' },
          'book': { en: 'Book Now', my: 'စာရင်းသွင်းရန်' },
          'account': { en: 'Account', my: 'အကောင့်' },
          'enterLocation': { en: 'Enter your location or postal code', my: 'တည်နေရာ သို့မဟုတ် စာတိုက်သင်္ကေတ ရိုက်ထည့်ပါ' },
          'findYourNearestAutoWorkshop': { en: 'Find Your Nearest Auto Workshop', my: 'သင့်အနီးဆုံး ကားပြင်ဆိုင်ရှာဖွေပါ' },
          'quickAndReliableAutoRepairServicesNearYou': { en: 'Quick and reliable auto repair services near you', my: 'သင့်နေရာအနီးပတ်ဝန်းကျင်ရှိ မြန်ဆန်စိတ်ချရသော ကားပြင်ဝန်ဆောင်မှုများ' },
          'premiumAutoCare': { en: 'Premium Auto Care', my: 'အဆင့်မြင့်ကားပြင်စောင့်ရှောက်မှု' },
          '9Am': { en: '09:00 AM', my: 'မနက် ၉ နာရီ' },
          '10:30Am': { en: '10:30 AM', my: 'မနက် ၁၀:၃၀' },
          '2Pm': { en: '02:00 PM', my: 'မွန်းလွဲ ၂ နာရီ' },
          '11Am': { en: '11:00 AM', my: 'မနက် ၁၁ နာရီ' },
          '1:30Pm': { en: '01:30 PM', my: 'မွန်းလွဲ ၁:၃၀' },
          '3Pm': { en: '03:00 PM', my: 'မွန်းလွဲ ၃ နာရီ' },
          'bookYourService': { en: 'Book Your Service', my: 'ဝန်ဆောင်မှုစာရင်းသွင်းပါ' },
          'vehicleDetails': { en: 'Vehicle Details', my: 'ယာဉ်အသေးစိတ်များ' },
          'serviesType': { en: 'Service Type', my: 'ဝန်ဆောင်မှုအမျိုးအစား' },
          'problemDescription': { en: 'Problem Description', my: 'ပြဿနာအကြောင်းရှင်းလင်းချက်' },
          'contactInformation': { en: 'Contact Information', my: 'ဆက်သွယ်ရန်အချက်အလက်' },
          'preferredDate&Time': { en: 'Preferred Date & Time', my: 'နှစ်သက်ရာရက်နှင့်အချိန်' },
          'regularMaintenance': { en: 'Regular Maintenance', my: 'ပုံမှန်ထိန်းသိမ်းမှု' },
          'brakeService': { en: 'Brake Service', my: 'ဘရိတ်ပြင်ဆင်မှု' },
          'engineRepair': { en: 'Engine Repair', my: 'အင်ဂျင်ပြင်ဆင်မှု' },
          'tireService': { en: 'Tire Service', my: 'တာယာဝန်ဆောင်မှု' },
          'certifiedMechanics': { en: 'Certified Mechanics', my: 'လိုင်စင်ရပညာရှင်များ' },
          'allOurMechanicsAreCertifiedProfessionals': { en: 'All our mechanics are certified professionals', my: 'ကျွန်ုပ်တို့၏ပညာရှင်အားလုံးသည် လိုင်စင်ရပညာရှင်များဖြစ်သည်' },
          'quickService': { en: 'Quick Service', my: 'မြန်ဆန်သောဝန်ဆောင်မှု' },
          'mostRepairsCompletedSameDay': { en: 'Most repairs completed same day', my: 'အများစုသောပြင်ဆင်မှုများကို တစ်ရက်တည်းပြီးစီးသည်' },
          'bestPrices': { en: 'Best Prices', my: 'အကောင်းဆုံးစျေးနှုန်းများ' },
          'competitivePricingGuaranteed': { en: 'Competitive pricing guaranteed', my: 'ယှဉ်ပြိုင်နိုင်သောစျေးနှုန်းများ အာမခံချက်' },
          '24/7 Support': { en: '24/7 Support', my: '၂၄ နာရီ ကူညီပံ့ပိုးမှု' },
          'alwaysHereWhenYouNeedUs': { en: 'Always here when you need us', my: 'သင်လိုအပ်သည့်အခါတိုင်း ရှိနေပါမည်' },
          'Morning(9AM-12PM)': { en: 'Morning (9AM - 12PM)', my: 'မနက် (၉နာရီမှ ၁၂နာရီ)' },
          'Afternoon(12PM-4PM)': { en: 'Afternoon (12PM - 4PM)', my: 'မွန်းလွဲ (၁၂နာရီမှ ၄နာရီ)' },
          'Evening(4PM-7PM)': { en: 'Evening (4PM - 7PM)', my: 'ညနေ (၄နာရီမှ ၇နာရီ)' },
          'selectTownship': { en: 'Select Township', my: 'မြို့နယ်ရွေးချယ်ပါ' },
          'aungmyaythazan': { en: 'Aungmyaythazan', my: 'အောင်မြေသာစံ' },
          'chanmyathazi': { en: 'Chanmyathazi', my: 'ချမ်းမြသာစည်' },
          'mahaaungmye': { en: 'Mahaaungmye', my: 'မဟာအောင်မြေ' },
          'chanayethazan': { en: 'Chanayethazan', my: 'ချားနိုးတံခါး' },
          'pyigyidagon': { en: 'Pyigyidagon', my: 'ပြည်ကြီးတံခွန်' },
          'amarapura': { en: 'Amarapura', my: 'အမရပူရ' },
          'patheingyi': { en: 'Patheingyi', my: 'ပုသိမ်ကြီး' },
          'okkyin': { en: 'Okkyin', my: 'ဥက္ကံ' },
          'mingyardon': { en: 'Mingyardon', my: 'မင်းကြာဒုံ' },
          'sintgaing': { en: 'Sintgaing', my: 'စဉ့်ကိုင်' },
          'madaya': { en: 'Madaya', my: 'မတ္တရာ' },
          'ngazun': { en: 'Ngazun', my: 'ငါန်းဇွန်' },
          'footerTagline': { en: 'Your trusted partner for all auto repair needs', my: 'ကားပြင်ဆိုင်လိုအပ်ချက်အားလုံးအတွက် ယုံကြည်စိတ်ချရသော မိတ်ဖက်တစ်ဦး' },
          'quickLinks': { en: 'Quick Links', my: 'အမြန်လင့်ခ်များ' },
          'aboutUs': { en: 'About Us', my: 'ကျွန်ုပ်တို့အကြောင်း' },
          'locations': { en: 'Locations', my: 'တည်နေရာများ' },
          'contact': { en: 'Contact', my: 'ဆက်သွယ်ရန်' },
          'oilChange': { en: 'Oil Change', my: 'ဆီအပြောင်းအလဲ' },
          'tireRotation': { en: 'Tire Rotation', my: 'တာယာလှည့်ပတ်မှု' },
          'contactUs': { en: 'Contact Us', my: 'ဆက်သွယ်ရန်' },
          'copyright': { en: '© 2025 Auto Workshop Finder. All rights reserved.', my: 'မူပိုင်ခွင့် © ၂၀၂၅ ကားပြင်ဆိုင်ရှာဖွေရေး။ မူပိုင်ခွင့်အားလုံးရရှိထားပါသည်။' },
          'bookService': { en: 'Book Service', my: 'ဝန်ဆောင်မှုစာရင်းသွင်းရန်' },
          'previous': { en: 'Previous', my: 'နောက်သို့' },
          'next': { en: 'Next', my: 'ရှေ့သို့' },
          'submitBooking': { en: 'Submit Booking', my: 'စာရင်းပေးသွင်းပါ' },
          'vehicleInformation': { en: 'Vehicle Information', my: 'ယာဉ်အချက်အလက်' },
          'vehicleMake': { en: 'Vehicle Make', my: 'ယာဉ်အမျိုးအစား' },
          'selectMake': { en: 'Select Make', my: 'အမျိုးအစားရွေးပါ' },
          'vehicleModel': { en: 'Vehicle Model', my: 'ယာဉ်မော်ဒယ်' },
          'selectModel': { en: 'Select Model', my: 'မော်ဒယ်ရွေးပါ' },
          'vehicleYear': { en: 'Year', my: 'ထုတ်လုပ်နှစ်' },
          'selectYear': { en: 'Select Year', my: 'နှစ်ရွေးပါ' },
          'currentMileage': { en: 'Current Mileage', my: 'လက်ရှိမိုင်နှုန်း' },
          'enterMileage': { en: 'Enter mileage', my: 'မိုင်နှုန်းရိုက်ထည့်ပါ' },
          'selectServices': { en: 'Select Services', my: 'ဝန်ဆောင်မှုများရွေးချယ်ပါ' },
          'oilChangeService': { en: 'Oil Change Service', my: 'ဆီအပြောင်းအလဲဝန်ဆောင်မှု' },
          'oilChangeDesc': { en: 'Complete oil change with premium synthetic oil and filter replacement', my: 'အရည်အသွေးမြင့်ဆီအပြောင်းနှင့် စစ်ထုတ်ကိရိယာအသစ်လဲလှယ်ခြင်း' },
          'duration30-45': { en: '30-45 minutes', my: '၃၀-၄၅ မိနစ်' },
          'brakeService': { en: 'Brake Service', my: 'ဘရိတ်ဝန်ဆောင်မှု' },
          'brakeServiceDesc': { en: 'Complete brake inspection, pad replacement, and rotor resurfacing', my: 'ဘရိတ်စစ်ဆေးခြင်း၊ ပက်အသစ်လဲခြင်းနှင့် ရိုတာပြန်လည်ပြုပြင်ခြင်း' },
          'duration1-2hours': { en: '1-2 hours', my: '၁-၂ နာရီ' },
          'tireRotation': { en: 'Tire Rotation', my: 'တာယာလှည့်ပတ်ခြင်း' },
          'tireRotationDesc': { en: 'Professional tire rotation, balancing, and pressure adjustment', my: 'တာယာလှည့်ပတ်ခြင်း၊ ညှိခြင်းနှင့် လေဖိအားညှိခြင်း' },
          'duration45-60': { en: '45-60 minutes', my: '၄၅-၆၀ မိနစ်' },
          'engineDiagnostic': { en: 'Engine Diagnostic', my: 'အင်ဂျင်စစ်ဆေးခြင်း' },
          'engineDiagnosticDesc': { en: 'Comprehensive engine diagnostic with computer analysis', my: 'ကွန်ပျူတာဖြင့် အင်ဂျင်အပြည့်အစုံစစ်ဆေးခြင်း' },
          'duration60-90': { en: '60-90 minutes', my: '၆၀-၉၀ မိနစ်' },
          'processingBooking': { en: 'Processing Your Booking', my: 'စာရင်းသွင်းမှုကိုစီမံဆောင်ရွက်နေသည်' },
          'pleaseWait': { en: 'Please wait while we confirm your appointment', my: 'ကျေးဇူးပြု၍ သင့်ချိန်းဆိုမှုအတည်ပြုချိန်ထိ စောင့်ဆိုင်းပါ' },
          'fullName': { en: 'Full Name', my: 'အမည်အပြည့်အစုံ' },
          'enterFullName': { en: 'Enter your full name', my: 'အမည်အပြည့်အစုံရိုက်ထည့်ပါ' },
          'emailAddress': { en: 'Email Address', my: 'အီးမေးလ်လိပ်စာ' },
          'enterEmail': { en: 'Enter your email', my: 'အီးမေးလ်လိပ်စာရိုက်ထည့်ပါ' },
          'phoneNumber': { en: 'Phone Number', my: 'ဖုန်းနံပါတ်' },
          'enterPhone': { en: 'Enter your phone number', my: 'ဖုန်းနံပါတ်ရိုက်ထည့်ပါ' },
          'specialInstructions': { en: 'Special Instructions', my: 'အထူးညွှန်ကြားချက်များ' },
          'enterSpecialInstructions': { en: 'Any additional notes or requests', my: 'အပိုမှတ်စုများ သို့မဟုတ် တောင်းဆိုချက်များ' },
          'selectMakeFirst': { en: 'Please select a make first', my: 'ကျေးဇူးပြု၍ အရင်ဆုံး ကားအမျိုးအစားရွေးပါ' }
        };

        let currentLang = localStorage.getItem('languagePreference') || 'en';

        // Initialize translate button text
        document.getElementById('translateBtn').textContent = currentLang === 'en' ? 'MY' : 'EN';
        document.getElementById('mobileTranslateBtn').textContent = currentLang === 'en' ? 'MY' : 'EN';

        function toggleLanguage() {
          currentLang = currentLang === 'en' ? 'my' : 'en';

          // Save preference to localStorage
          localStorage.setItem('languagePreference', currentLang);

          document.getElementById('translateBtn').textContent = currentLang === 'en' ? 'MY' : 'EN';
          document.getElementById('mobileTranslateBtn').textContent = currentLang === 'en' ? 'MY' : 'EN';
          translatePage();
        }

        function translatePage() {
          // Translate elements with data-translate attribute
          document.querySelectorAll('[data-translate]').forEach(el => {
            const key = el.dataset.translate;
            if (translations[key]) {
              el.textContent = translations[key][currentLang];
            }
          });

          // Translate placeholders
          document.querySelectorAll('[data-translate-placeholder]').forEach(el => {
            const key = el.dataset.translatePlaceholder;
            if (translations[key]) {
              el.placeholder = translations[key][currentLang];
            }
          });

          // Set font family
          document.body.style.fontFamily = currentLang === 'my'
            ? "'Noto Sans Myanmar', sans-serif"
            : "system-ui, sans-serif";
        }

        window.addEventListener('DOMContentLoaded', () => {
          translatePage();
        });

        let seconds = 10;
        const countdownEl = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            seconds--;
            countdownEl.textContent = seconds;
            
            if(seconds <= 0) {
                clearInterval(timer);
                window.location.reload();
            }
        }, 1000);
      </script>
</body>

</html>