<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Inventory - ') }}{{ $cadet->user->name }}
            </h2>
            <a href="{{ route('cadet.inventory.profile') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                View Profile Summary
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Active Equipment Loans Alert -->
            @if($activeLoans->isNotEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                You have {{ $activeLoans->count() }} active equipment loan(s). 
                                @php $overdueCount = $activeLoans->filter(fn($loan) => $loan->isOverdue())->count(); @endphp
                                @if($overdueCount > 0)
                                    <span class="font-semibold text-red-600">{{ $overdueCount }} overdue!</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Uniform Sizes Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">My Uniform Sizes</h3>
                    
                    <!-- Add/Update Uniform Size Form -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Update Uniform Size</h4>
                        <form method="POST" action="{{ route('cadet.inventory.uniform-size.update') }}" class="flex flex-wrap items-end gap-4">
                            @csrf
                            <div class="flex-1 min-w-48">
                                <label for="component_id" class="block text-sm font-medium text-gray-700 mb-1">Uniform Component</label>
                                <select name="component_id" id="component_id" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Component</option>
                                    @foreach($uniformComponents as $component)
                                        <option value="{{ $component->id }}">{{ $component->component_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1 min-w-32">
                                <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                                <input type="text" name="size" id="size" required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="e.g., M, 9, 32">
                            </div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                                Update Size
                            </button>
                        </form>
                    </div>

                    <!-- Current Uniform Sizes -->
                    @if($uniformSizes->isEmpty())
                        <p class="text-gray-500">No uniform sizes recorded yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($uniformSizes as $uniformSize)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $uniformSize->uniformComponent->component_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $uniformSize->size }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($uniformSize->is_issued)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Issued
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if(!$uniformSize->is_issued)
                                                    <form method="POST" action="{{ route('cadet.inventory.uniform-size.delete', $uniformSize) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                                                onclick="return confirm('Are you sure you want to remove this size?')">
                                                            Remove
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Equipment Loans Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Equipment Loans</h3>
                    
                    <!-- New Loan Form -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Borrow Equipment</h4>
                        <form method="POST" action="{{ route('cadet.inventory.loan.create') }}" class="flex flex-wrap items-end gap-4">
                            @csrf
                            <div class="flex-1 min-w-48">
                                <label for="item_id" class="block text-sm font-medium text-gray-700 mb-1">Equipment Item</label>
                                <select name="item_id" id="item_id" required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Item</option>
                                    @foreach($availableItems as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }} ({{ $item->available_quantity }} available)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex-1 min-w-24">
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" name="quantity" id="quantity" min="1" required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="flex-1 min-w-36">
                                <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Borrow Date</label>
                                <input type="date" name="borrow_date" id="borrow_date" required
                                       value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                                Borrow Item
                            </button>
                        </form>
                    </div>

                    <!-- Active Loans -->
                    @if($activeLoans->isNotEmpty())
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-3">Active Loans</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($activeLoans as $loan)
                                            <tr class="{{ $loan->isOverdue() ? 'bg-red-50' : '' }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $loan->inventoryItem->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $loan->quantity }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $loan->borrow_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($loan->isOverdue())
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Overdue ({{ $loan->days_overdue }} days)
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Active
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <button onclick="openReturnModal({{ $loan->id }}, '{{ $loan->inventoryItem->name }}', '{{ $loan->borrow_date->format('Y-m-d') }}')"
                                                            class="text-indigo-600 hover:text-indigo-900">
                                                        Return Item
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Past Loans -->
                    <div>
                        <h4 class="font-medium text-gray-800 mb-3">Loan History</h4>
                        @if($pastLoans->isEmpty())
                            <p class="text-gray-500">No past loans found.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($pastLoans as $loan)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $loan->inventoryItem->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $loan->quantity }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $loan->borrow_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $loan->return_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $loan->borrow_date->diffInDays($loan->return_date) }} days
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $pastLoans->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Item Modal -->
    <div id="returnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Return Equipment</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modalDescription">
                        Are you sure you want to return this item?
                    </p>
                </div>
                <form id="returnForm" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">Return Date</label>
                        <input type="date" name="return_date" id="return_date" 
                               value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex justify-center space-x-4">
                        <button type="button" onclick="closeReturnModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Return Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const successAlert = document.querySelector('.fixed.bottom-4');
                if (successAlert) successAlert.remove();
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const errorAlert = document.querySelector('.fixed.bottom-4.bg-red-500');
                if (errorAlert) errorAlert.remove();
            }, 3000);
        </script>
    @endif

    <script>
        function openReturnModal(loanId, itemName, borrowDate) {
            document.getElementById('modalTitle').textContent = `Return ${itemName}`;
            document.getElementById('modalDescription').textContent = `Return ${itemName} borrowed on ${borrowDate}?`;
            document.getElementById('returnForm').action = `/cadet/inventory/loan/${loanId}/return`;
            document.getElementById('return_date').setAttribute('min', borrowDate);
            document.getElementById('returnModal').classList.remove('hidden');
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('returnModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReturnModal();
            }
        });
    </script>
</x-app-layout>