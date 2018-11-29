package pruebaRetrofitJava;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class LibroPutCallback implements Callback<Void> {

    @Override
    public void onResponse(Call<Void> call, Response<Void> response) {
        System.out.println("Libro actualizado correctamente!");
    }

    @Override
    public void onFailure(Call<Void> call, Throwable throwable) {
        System.out.println("No se ha podido actualizar el libro");
    }
}
